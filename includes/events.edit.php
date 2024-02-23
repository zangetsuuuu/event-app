<div class="modal fade" id="editID<?= $row['event_id']; ?>" tabindex="-1" aria-labelledby="editLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="editEventLabel">
                    <i class="fa-solid fa-pen me-2"></i>Edit Event
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                    <?php foreach ($users as $user): ?>
                        <input type="hidden" name="organizerName" value="<?= $user['name']; ?>">
                        <input type="hidden" name="organizerEmail" value="<?= $user['email']; ?>">
                    <?php endforeach; ?>
                    <div class="form-label mb-3">
                        <label for="eventName" class="fw-medium mb-2">Event Name</label>
                        <input type="text" class="form-control" name="eventName" id="eventName"
                            placeholder="Enter event name" value="<?= $row['event_name']; ?>" required>
                    </div>
                    <div class="form-label mb-3">
                        <label for="eventDesc" class="fw-medium mb-2">Description</label>
                        <textarea type="text" class="form-control" name="eventDesc" id="eventDesc" style="resize: none;"
                            placeholder="Enter event description" required><?= $row['event_description']; ?></textarea>
                    </div>
                    <div class="row g-0 g-md-1 g-lg-4">
                        <div class="col-12 col-lg-6">
                            <div class="form-label mb-3">
                                <label for="eventDate" class="fw-medium mb-2">Date</label>
                                <input type="date" class="form-control" name="eventDate" id="eventDate"
                                    placeholder="Select event date" value="<?= $row['event_date']; ?>" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-label mb-3">
                                <label for="eventDeadline" class="fw-medium mb-2">Registration Deadline</label>
                                <input type="date" class="form-control" name="eventDeadline" id="eventDeadline"
                                    placeholder="Select registration deadline"
                                    value="<?= $row['registration_deadline']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 g-md-1 g-lg-4">
                        <div class="col-12 col-lg-3">
                            <div class="form-label mb-3">
                                <label for="maxParticipants" class="fw-medium mb-2">Max Participants</label>
                                <input type="text" class="form-control" name="maxParticipants" id="maxParticipants"
                                    placeholder="e.g. 100" value="<?= $row['max_participants']; ?>" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-label mb-3">
                                <label for="fee" class="fw-medium mb-2">Fee
                                    <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="text" class="form-control" name="fee" id="fee" placeholder="Rp." value="<?= $row['registration_fee'] != 0 ? number_format($row['registration_fee'], 0, ',', '') : '' ?>">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-label mb-3">
                                <label for="eventLoc" class="fw-medium mb-2">Location</label>
                                <input type="text" class="form-control" name="eventLoc" id="eventLoc"
                                    placeholder="Enter event location" value="<?= $row['event_location']; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-label mb-3">
                                    <label for="eventImage" class="fw-medium mb-2">New Image
                                        <span class="text-muted">(Optional)</span>
                                    </label>
                                    <input type="file" class="form-control" name="image" id="eventImage">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="editEvent" class="btn btn-success">
                            <i class="fa-solid fa-check me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit event End -->