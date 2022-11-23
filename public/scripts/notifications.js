// close notifications
document.addEventListener('DOMContentLoaded', () => {
	(document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
		const $notification = $delete.parentNode;

		$delete.addEventListener('click', () => {
			if ($notification.parentNode) {
				$notification.parentNode.removeChild($notification);
			}
		});
	});
});
