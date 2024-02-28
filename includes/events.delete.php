<div class="modal fade" id="deleteID<?= $row['event_id']; ?>" tabindex="-1" aria-labelledby="deleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 448 512" fill="#DC3545">
                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                    </svg>
                    <p class="mt-3">
                        Are you sure you want to delete "<?= $row['event_name']; ?>"?
                    </p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-outline-secondary w-50" data-bs-dismiss="modal">Cancel
                    </button>
                    <form action="" method="post" class="w-50">
                        <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                        <button type="submit" name="deleteEvent" class="btn btn-danger w-100">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>