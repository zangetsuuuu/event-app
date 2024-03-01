<div class="modal fade" id="unjoinID<?= $row['event_id']; ?>" tabindex="-1" aria-labelledby="unjoinLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 448 512" fill="#DC3545">
                        <path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM312 376c13.3 0 24-10.7 24-24s-10.7-24-24-24H136c-13.3 0-24 10.7-24 24s10.7 24 24 24H312z"/>
                    </svg>
                    <p class="mt-4">
                        Are you sure you want to unjoin "<?= $row['event_name']; ?>"?
                    </p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">Cancel
                    </button>
                    <form action="" method="post" class="w-50">
                        <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                        <input type="hidden" name="userID" value="<?= $id; ?>">
                        <button type="submit" name="unjoinEvent" class="btn btn-danger w-100">Unjoin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>