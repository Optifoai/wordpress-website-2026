(function ($) {
	'use strict';

	$('#optifo-section-sortable').sortable({
		update: function () {
			$('#optifo-section-sortable .optifo-sortable-item').each(function (i) {
				$(this).find('.optifo-order-input').val(i + 1);
			});
		}
	});

	/**
	 * Get repeater rows excluding the hidden clone template.
	 *
	 * @param {jQuery} $wrap Repeater container.
	 * @return {jQuery}
	 */
	function getRepeaterRows($wrap) {
		return $wrap.children('.optifo-repeater-row');
	}

	$('.optifo-nested-repeater').sortable({
		items: '> .optifo-repeater-row',
		handle: '.optifo-repeater-row-header',
		axis: 'y'
	});

	/**
	 * Reindex all repeater row field names after add/remove/reorder.
	 *
	 * @param {jQuery} $wrap Repeater container.
	 */
	function reindexRepeaterRows($wrap) {
		var prefix = $wrap.data('prefix');
		getRepeaterRows($wrap).each(function (i) {
			var $row = $(this);
			$row.attr('data-index', i);
			$row.find('.optifo-field[data-field-key]').each(function () {
				var fieldKey = $(this).data('field-key');
				$(this).find('[name]').attr('name', prefix + '[' + i + '][' + fieldKey + ']');
			});
		});
	}

	// Fix row indices on page load (template row must not be counted).
	$('.optifo-nested-repeater').each(function () {
		reindexRepeaterRows($(this));
	});

	$(document).on('click', '.optifo-upload-image', function (e) {
		e.preventDefault();
		if ($(this).is(':disabled')) {
			return;
		}
		var button = $(this);
		var input = button.siblings('.optifo-image-id').length
			? button.siblings('.optifo-image-id')
			: button.closest('.optifo-field, p, td').find('.optifo-image-id').first();
		var frame = wp.media({ title: 'Select Image', multiple: false });
		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			input.val(attachment.id);
			button.siblings('img').remove();
			button.parent().find('img').not(button).remove();
			button.after('<br><img src="' + attachment.url + '" style="max-width:80px;margin-top:8px;">');
		});
		frame.open();
	});

	$(document).on('click', '.optifo-add-row', function (e) {
		e.preventDefault();
		var $wrap = $(this).closest('.optifo-nested-repeater');
		var $template = $wrap.find('.optifo-repeater-row-template .optifo-repeater-row').first();

		if (!$template.length) {
			return;
		}

		var $newRow = $template.clone();

		$newRow.find('input, textarea').each(function () {
			var $el = $(this);
			$el.prop('disabled', false);
			if ($el.hasClass('optifo-image-id')) {
				$el.val('');
			} else if ($el.attr('type') === 'checkbox') {
				$el.prop('checked', false);
			} else {
				$el.val('');
			}
		});
		$newRow.find('button.optifo-upload-image').prop('disabled', false);
		$newRow.find('img').remove();

		$(this).parent().before($newRow);
		reindexRepeaterRows($wrap);
	});

	$(document).on('click', '.optifo-remove-row', function (e) {
		e.preventDefault();
		var $wrap = $(this).closest('.optifo-nested-repeater');
		var $rows = getRepeaterRows($wrap);
		if ($rows.length <= 1) {
			$rows.find('input, textarea').val('');
			$rows.find('img').remove();
			$rows.find('.optifo-image-id').val('');
			return;
		}
		$(this).closest('.optifo-repeater-row').remove();
		reindexRepeaterRows($wrap);
	});

})(jQuery);
