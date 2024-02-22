<div class="modal fade" id="newEvent" tabindex="-1" aria-labelledby="newEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="newEventLabel">
                    <i class="fa-solid fa-calendar-day me-2"></i>New Event
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php foreach ($users as $row): ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="userID" value="<?= $row['user_id']; ?>">
                        <input type="hidden" name="organizerName" value="<?= $row['name']; ?>">
                        <input type="hidden" name="organizerEmail" value="<?= $row['email']; ?>">
                        <div class="form-label mb-3">
                            <label for="eventName" class="fw-medium mb-2">Event Name</label>
                            <input type="text" class="form-control" name="eventName" id="eventName"
                                placeholder="Enter event name" required>
                        </div>
                        <div class="form-label mb-3">
                            <label for="eventDesc" class="fw-medium mb-2">Description</label>
                            <textarea type="text" class="form-control" name="eventDesc" id="eventDesc" style="resize: none;"
                                placeholder="Enter event description" required></textarea>
                        </div>
                        <div class="row g-0 g-md-1 g-lg-4">
                            <div class="col-12 col-lg-6">
                                <div class="form-label mb-3">
                                    <label for="eventDate" class="fw-medium mb-2">Date</label>
                                    <input type="date" class="form-control" name="eventDate" id="eventDate"
                                        placeholder="Select event date" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-label mb-3">
                                    <label for="eventDeadline" class="fw-medium mb-2">Registration Deadline</label>
                                    <input type="date" class="form-control" name="eventDeadline" id="eventDeadline"
                                        placeholder="Select registration deadline" required>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0 g-md-1 g-lg-4">
                            <div class="col-12 col-lg-3">
                                <div class="form-label mb-3">
                                    <label for="maxParticipants" class="fw-medium mb-2">Max Participants</label>
                                    <input type="text" class="form-control" name="maxParticipants" id="maxParticipants"
                                        placeholder="e.g. 100" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="form-label mb-3">
                                    <label for="fee" class="fw-medium mb-2">Fee
                                        <span class="text-muted">(Optional)</span>
                                    </label>
                                    <input type="text" class="form-control" name="fee" id="fee" placeholder="Rp.">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-label mb-3">
                                    <label for="eventLoc" class="fw-medium mb-2">Location</label>
                                    <input type="text" class="form-control" name="eventLoc" id="eventLoc"
                                        placeholder="Enter event location" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-label mb-3">
                                    <label for="eventImage" class="fw-medium mb-2">Image</label>
                                    <input type="file" class="form-control" name="image" id="eventImage" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="createEvent" class="btn btn-success">
                                <i class="fa-solid fa-plus me-2"></i>Create Event
                            </button>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>