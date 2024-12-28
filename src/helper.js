/**
 * Define which blocks will be changed by the following functions.
 * Only core/list will be changed.
 *
 * @type {string[]}
 */
export const enableSidebarSelectOnBlocks = [
	'core/list'
];

/**
 * Remove icons from child core/list-item recursive.
 * And set the type to each sub core/list recursive,
 *
 * @param clientId The ID of the block.
 * @param type The new list type.
 */
export function removeIconsFromChildren( clientId, type ) {
	// get the block object.
	let block = wp.data.select('core/block-editor').getBlocksByClientId(clientId)[0];

	// bail if block could not be loaded.
	if( ! block ) {
		return;
	}

	// bail if block is not core/list.
	if( 'core/list' !== block.name ) {
		return;
	}

	// get its children.
	let children = block.innerBlocks;

	// loop through them.
	children.forEach(function (child) {
		// remove icon from this core/list-item.
		wp.data.dispatch('core/block-editor').updateBlockAttributes(child.clientId, {icon: undefined}, false)

		// get its children (core/list).
		child.innerBlocks.forEach(function(sublist) {
			// set type for this core/list.
			wp.data.dispatch('core/block-editor').updateBlockAttributes(sublist.clientId, {type: type, className: ''}, false)

			// and loop through its children.
			removeIconsFromChildren(sublist.clientId, type)
		});
	});
}
