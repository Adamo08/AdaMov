<?php require ADMINVIEWS."layouts/header.php"; ?>

<style>
    .btn-xs {
        padding: 0.25rem 0.55rem;
        font-size: 0.75rem;
        line-height: 1;
        margin:0.1rem 0.2rem;
    }

</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Messages</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Messages Card -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sender</th>
                                    <th>Message</th>
                                    <th>Attachment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0;?>
                                <?php foreach ($messages as $message): ?>
                                    <?php 
                                        $file_extension = pathinfo($message['attachment'], PATHINFO_EXTENSION);
                                        $file_path = "/AdaMov/public/assets/admin/" . $message['attachment'];
                                        $file_icon = '';
                                        $file_label = '';

                                        if (!empty($message['attachment'])) {
                                            if (in_array($file_extension, ['jpg', 'jpeg', 'png'])) {
                                                $file_icon = '<a href="#" class="view-image" data-img="'.$file_path.'" title="View Image">
                                                                <i class="fas fa-image text-primary"></i>
                                                            </a>';
                                            } elseif ($file_extension === 'pdf') {
                                                $file_icon = '<a href="'.$file_path.'" target="_blank" title="View PDF">
                                                                <i class="fas fa-file-pdf text-danger"></i>
                                                            </a>';
                                            } elseif ($file_extension === 'docx') {
                                                $file_icon = '<a href="'.$file_path.'" target="_blank" title="Download DOCX">
                                                                <i class="fas fa-file-word text-info"></i>
                                                            </a>';
                                            } else {
                                                $file_icon = '<span class="badge badge-secondary">Unknown</span>';
                                            }
                                        } else {
                                            $file_icon = '<span class="badge badge-light">No Attachment</span>';
                                        }
                                    ?>
                                    <tr 
                                        class="<?php echo $message['is_read'] ? 'table-light' : 'table-warning'; ?>"
                                        data-id="<?php echo $message['id']; ?>"
                                    >
                                        <td><?php echo (++$i); ?></td>
                                        <td><?php echo htmlspecialchars($message['sender_name']); ?></td>
                                        <td><?php echo htmlspecialchars($message['message']); ?></td>
                                        <td><?php echo $file_icon; ?></td>
                                        <td><?php echo date('d M Y, H:i', strtotime($message['created_at'])); ?></td>
                                        <td class="d-flex justify-content-arround flex-wrap gap-2">
                                            <button 
                                                class="btn btn-success btn-xs mark-as-read" 
                                                data-id="<?php echo $message['id']; ?>" 
                                                title="Mark as Read"
                                                <?php echo $message['is_read'] ? 'disabled' : ''; ?>
                                            >
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-danger btn-xs delete-message" data-id="<?php echo $message['id']; ?>" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-info btn-xs reply-message" data-id="<?php echo $message['id']; ?>" data-sender="<?php echo $message['sender_id']; ?>" title="Reply">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->

</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <img src="" id="modalImage" class="img-fluid" alt="Preview">
        </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('.view-image').click(function (e) {
            e.preventDefault();
            let imgSrc = $(this).data('img');
            $('#modalImage').attr('src', imgSrc);
            $('#imageModal').modal('show');
        });

    });
</script>

<?php require ADMINVIEWS."layouts/footer.php"; ?>
