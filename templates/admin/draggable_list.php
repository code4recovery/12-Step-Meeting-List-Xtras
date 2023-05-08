<?php
/**
 * Draggable list field template.
 *
 * This template is not a general purpose field like the others. It is specific
 * to the tsml_coluns variable
 *
 * @author Anthony B <anthony@bustedspring.com>
 * @version 1.0.0
 * @since 1.0.0
 * @package TSMLXtras\Templates\Admin
 */

?>
<div id="sortable_<?php echo $data->id; ?>">
	<small class="description tw-block tw-mb-2"><?php _e( $data->description, $data->slug ); ?></small>
	<div style="border: 1px solid;" class="tw-mb-2 tw-border tw-border-zinc-200 tw-rounded-md tw-p-4 tw-gap-x-2 tw-flex tw-flex-col tw-items-center tw-justify-start tw-font-bold">
		<div class="tw-flex tw-flex-row tw-items-center tw-justify-start tw-w-full">
			<label class="tw-whitespace-nowrap tw-mr-2" for="<?php echo $data->id; ?>_reset">Revert to default</label>
			<input id="<?php echo $data->id; ?>_reset" type="checkbox" name="<?php echo $data->id; ?>_reset">
		</div>
		<div class="tw-flex tw-flex-row tw-items-center tw-justify-start tw-w-full">
			<small id="reset_warning" class="tw-hidden w-full tw-text-red-700"><strong><em>You can uncheck this box to get your original values back. Once you save, your original values will lost.</em></strong></small>
		</div>
	</div>
	<ul class="tw-list-none tw-m-0 tw-p-2 tw-bg-zinc-100 tw-rounded-sm tw-shadow-sm tw-flex tw-justify-start tw-gap-2 tw-font-bold" id="legend">
		<li class="tw-w-36 tw-ml-8">Key</li>
		<li class="tw-w-52">Label</li>
		<li class="tw-w-28 tw-flex tw-flex-col tw-items-center">Turn Off</li>
	</ul>
	<ul class="tw-list-none tw-m-0 tw-p-2" id="sortable">
		<?php foreach ( $data->draggables as $order => $column ): ?>
			<li id="<?php echo $column['key']; ?>"
				class="ui-state-default hover:tw-bg-zinc-50 tw-flex tw-items-center tw-justify-start tw-justify-items-start tw-cursor-grab tw-w-full tw-gap-2<?php echo $column['exclude'] === true ? ' tw-line-through' : '' ?>">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-inline-block tw-w-4 tw-h-4">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
				</svg>
				<span class="tw-ml-2 tw-w-36"><?php echo $column['key']; ?></span>
				<input class="tw-w-52" type="text" id="<?php echo $column['key']; ?>_name" name="<?php echo $column['key']; ?>_name" value="<?php echo $column['label']; ?>">
				<span class="tw-w-28 tw-flex tw-flex-col tw-items-center">
					<input type="checkbox" id="<?php echo $column['key']; ?>_show" <?php echo $column['exclude'] === true ? 'checked="checked"' : '' ?> name="<?php echo $data->id; ?>_show[]">
				</span>
				<?php if ((property_exists($data, 'deletable')) && (!in_array($column['key'], array_column($data->defaults, 'key')))): ?>
					<a class="delete-button tw-text-red-300 hover:tw-text-red-500 tw-cursor-pointer tw-uppercase tw-text-sm" data-value="<?php echo $column['key']; ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="tw-w-5 tw-h-5">
							<path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
						</svg>
					</a>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php if (property_exists($data, 'add_another_enabled')): ?>
		<div class="tw-border tw-border-solid tw-border-gray-300 tw-rounded-md tw-p-4">
			<div class="tw-flex tw-flex-row tw-gap-2">
				<label class="tw-basis-1/3">
					<span class="tw-block tw-text-xs tw-font-bold ">Key</span>
					<input class="tw-basis-1/3" type="text" id="keyAdd" name="keyAdd" />
				</label>
				<label class="tw-basis-1/3">
					<span class="tw-block tw-text-xs tw-font-bold ">Label</span>
					<input class="tw-basis-1/3" type="text" id="valAdd" name="valAdd" />
				</label>
				<div class="tw-flex tw-justify-start tw-items-end">
					<input type="button" class="button-primary" value="Add Another" id="tsmlxtras_add_another" />
				</div>
			</div>
		</div>
		<small class="tw-text-sm tw-text-red-500 tw-italic tw-mt-2 tw-block">Items are inserted at the last position that does NOT have "exclude" checked.</small>
	<?php endif; ?>
	<input id="<?php echo $data->slug; ?>_settings[<?php echo $data->id ?>]" type="hidden" name="<?php echo $data->slug ?>_settings[<?php echo $data->id ?>]">
</div>
<script>
	jQuery(document).ready(function( $ ) {
		// Fields/Elements
		let id               = '<?php echo $data->id; ?>'
		let container 	     = $('#sortable_'+id)
        let hiddenField	     = container.find( 'input:hidden' )
        let reset		     = container.find('#'+id+'_reset')
        let checkboxes       = container.find( '#sortable :checkbox' )
        let textfields       = container.find( '#sortable input:text' )
		let addAnotherButton = container.find('input#tsmlxtras_add_another')
		let deleteButton     = container.find('a.delete-button')

		// Values storage
        let itemOrder = JSON.parse('<?php echo json_encode($data->draggables) ?>')
        let defaultItemOrder = JSON.parse('<?php echo json_encode($data->defaults); ?>')
        let oldItemOrder = []
		// Set the hidden field value initially
		updateValueField()

		// Sortable list
        let sortableList = container.children('#sortable').sortable();

        // Delete button watcher
		deleteButton.on('click', function (e) {
            e.preventDefault()
			$(this).parent().remove()
            updateAllFields()
            updateValueField()
        })

        // Add another button watcher
		addAnotherButton.on('click', function (e) {
            e.preventDefault()
            let key = $("input[name='keyAdd']").val()
            let val = $("input[name='valAdd']").val()
			// New <Li> html
			if (key && val) {
                var li  = `
				<li id="${key}" class="ui-state-default hover:tw-bg-zinc-50 tw-flex tw-items-center tw-justify-start tw-justify-items-start tw-cursor-grab tw-w-full tw-gap-2">
                	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="tw-inline-block tw-w-4 tw-h-4">
                		<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                	</svg>
					<span class="tw-ml-2 tw-w-36">${key}</span>
					<input class="tw-w-52" type="text" id="${key}_name" name="${key}_name" value="${val}">
					<span class="tw-w-28 tw-flex tw-flex-col tw-items-center">
					<input type="checkbox" id="${key}_show" name="${id}_show[]">
				</li>`
				var lastAcive = $("div#sortable_"+id+" ul#sortable li:not('.tw-line-through')").last()
				// Insert item into sortable list
				$(li).insertAfter(lastAcive)
                itemOrder.push({key:key, label:val, exclude:false, custom:true})
                sortableList.trigger('sortupdate')
                updateValueField()
				$('#keyAdd').val('')
				$('#valAdd').val('')
			} else {
                alert('Key and Label values cannot be empty. Please fill both fields.')
			}
		})

		// Sortable event watcher
		sortableList.on('sortupdate', function (){
			// Set itemOrder to new order
            let newOrder = $(this).sortable('toArray')
            let newItemOrder = []
			// Create a newly ordered object after reordering
			$.each(newOrder, function (idx, fieldKey) {
				newItemOrder[idx] = itemOrder.find(obj => obj.key == fieldKey)
			})
			// Assign new value to main object
			itemOrder = newItemOrder
			// Set hidden input value
			updateValueField()
		})

		// Checkboxes event watcher
		checkboxes.on('click', function () {
			// Get the id of the checkbox (will match $tsml_columns key
            let checkedId = $(this).attr('id').replace('_show', '');
            let checkedIndex = itemOrder.findIndex(obj => obj.key === checkedId)
            let parentLi = $(this).parent().parent()
			// Prevent location & location_group checked at the same time as they are redundant
			if (checkedId === 'location_group' && $(this).is(':checked') === true) {
				// Set strikethrough class
				parentLi.addClass('tw-line-through')
				// Push the value onto our variable
				itemOrder[checkedIndex].exclude = true
				// Move this item to end of draggable & update sortable internals
				parentLi.insertAfter($("#sortable_"+id+" #sortable li:last"))
				sortableList.trigger("sortupdate")
				// If location is checked, remove it from our values, remove linethru & uncheck it
				if ($('input#location_show').is(':checked') === true) {
					$('input#location_show').prop('checked', false)
					$('li#location').removeClass('tw-line-through')
                    let locidx = itemOrder.findIndex(obj => obj.key === 'location')
					itemOrder[locidx].exclude = false
				}
			}
			else if (checkedId === 'location' && $(this).is(':checked') === true) {
				// Set strikethrough class
				parentLi.addClass('tw-line-through')
				// Push the value onto our variable
				itemOrder[checkedIndex].exclude = true
				// Move this item to end of draggable & update sortable internals
				parentLi.insertAfter($("#sortable_<?php echo $data->id; ?> #sortable li:last"))
				sortableList.trigger("sortupdate")
				// If location_group is checked, remove it from our values, remove linethru & uncheck it
				if ($('input#location_group_show').is(':checked') === true) {
					$('input#location_group_show').prop('checked', false)
					$('li#location_group').removeClass('tw-line-through')
                    let locgroupidx = itemOrder.findIndex(obj => obj.key === 'location_group')
					itemOrder[locgroupidx].exclude = false
				}
			}
			else {
				if ($(this).is(':checked') === true) {
					// Set strikethrough class
					parentLi.addClass('tw-line-through')
					// Push the value onto our variable
					itemOrder[checkedIndex].exclude = true
					// Move this item to end of draggable & update sortable internals
					parentLi.insertAfter($("#sortable_"+id+" #sortable li:last"))
					sortableList.trigger("sortupdate")
				} else {
					// Remove strikethrough class
					parentLi.removeClass('tw-line-through')
					// Remove the value from our variable
					itemOrder[checkedIndex].exclude = false
				}
			}
			// Set hidden input value
			updateValueField()
		})

		// Text field event watcher
		textfields.on('input', function () {
			// Get the key of the item we are going to update
            let fieldId = $(this).attr('id').replace('_name', '')
            let fieldIdx = itemOrder.findIndex(obj => obj.key === fieldId)
			itemOrder[fieldIdx].label = $(this).val()
			updateValueField()
		})

		// Reset to default
		reset.on('click', function () {
			if ($(this).is(':checked') === true) {
				$('#reset_warning').removeClass('tw-hidden')
				oldItemOrder = itemOrder
				itemOrder = defaultItemOrder
			} else {
				$('#reset_warning').addClass('tw-hidden')
				itemOrder = oldItemOrder
				oldItemOrder = []
			}
			updateAllFields()
		})

		// Update hidden field when things are changed
		function updateValueField() {
			hiddenField.val(JSON.stringify(itemOrder))
		}

		// Update checkboxes & text fields
		function updateAllFields() {
			// New list items to insert
			var newList = []
			itemOrder.forEach((fieldoption, order) => {
				// Set text field values
				$('input#' + fieldoption.key + '_name').val(fieldoption.label)
				let li = $('li#' + fieldoption.key)
				// Set checkbox field values
				let ckbx = $('#' + fieldoption.key + '_show');
				ckbx.prop('checked', fieldoption.exclude)
				let parentli = ckbx.parent().parent()
				if (fieldoption.exclude === true) {
					parentli.addClass('tw-line-through')
				} else {
					parentli.removeClass('tw-line-through')
				}
				newList.push(parentli)
			})

			// Re-insert in proper order & update jquery sortable
			sortableList.prepend(newList)
			sortableList.trigger("sortupdate")
		}
	});
</script>
