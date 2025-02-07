<?php require ADMINVIEWS . "layouts/header.php"; ?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Contact Another Admin</h1>
        <p class="text-muted">Send a private message to another admin.</p>
    </div>

    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-envelope"></i> New Message</h6>
                </div>
                <div class="card-body">
                    <form id="contactAdminForm" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="sender_id" value="<?= $_SESSION['admin_id']; ?>">

                        <!-- Select Admin to Contact -->
                        <div class="form-group">
                            <label for="receiver_id">Select Admin</label>
                            <select class="form-control" id="receiver_id" name="receiver_id" required>
                                <option value="" disabled selected>Choose an admin</option>
                                <?php foreach ($admins as $admin): ?>
                                    <?php if ($admin['id'] != $_SESSION['admin_id']): ?>
                                        <option value="<?= $admin['id']; ?>">
                                            <?= htmlspecialchars($admin['fname'] . ' ' . $admin['lname']); ?> (<?= htmlspecialchars($admin['email']); ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message..." required></textarea>
                        </div>

                        <!-- Attachments (Optional) -->
                        <div class="form-group">
                            <label for="attachment">Attachment (Optional)</label>
                            <input type="file" class="form-control-file" id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.docx">
                            <small class="text-muted">Allowed formats: JPG, PNG, PDF, DOCX (Max: 5MB)</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </div>

                        <!-- Alert Messages -->
                        <div id="responseMessage" class="mt-3"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ADMINVIEWS . "layouts/footer.php"; ?>
