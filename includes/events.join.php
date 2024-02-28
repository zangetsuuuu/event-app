<div class="modal fade" id="joinID<?= $row['event_id']; ?>" tabindex="-1" aria-labelledby="joinLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 448 512">
                        <path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192zM224 248c13.3 0 24 10.7 24 24v56h56c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V376H144c-13.3 0-24-10.7-24-24s10.7-24 24-24h56V272c0-13.3 10.7-24 24-24z"/>
                    </svg>
                    <p class="mt-4">
                        Are you sure you want to join "<?= $row['event_name']; ?>"?
                    </p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">Cancel
                    </button>
                    <form action="" method="post" class="w-50">
                        <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                        <input type="hidden" name="userID" value="<?= $id; ?>">
                        <button type="submit" name="joinEvent" class="btn btn-dark w-100">Join</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>