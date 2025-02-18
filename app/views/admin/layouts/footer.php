            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; AdaMov <script>document.write(new Date().getFullYear());</script></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo url("admin/logout")?>">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="message-content lead text-dark"></p>
                    <p class="message-time text-muted"></p>
                    <div class="message-attachment mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo ADMINASSETS?>vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo ADMINASSETS?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo ADMINASSETS?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo ADMINASSETS?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo ADMINASSETS?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo ADMINASSETS?>js/demo/chart-area-demo.js"></script>
    <script src="<?php echo ADMINASSETS?>js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo ADMINASSETS?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo ADMINASSETS?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo ADMINASSETS?>js/demo/datatables-demo.js"></script>

    <!-- Script js to handle ajax request  -->
    <script src="<?php echo ADMINASSETS;?>js/admin_ajax_requests.js"></script>


    <!-- Sweet Alerts CDN js link  -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</body>

</html>