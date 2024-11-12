<style>
        .icon-red {
            color: red;
        }
        #dr {
            background-color: #f8f9fa; 
            border: 1px solid #dee2e6; 
            border-radius: 0.25rem; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 2px 0; 
             /* text-align:center; */
        }
        .content {
            color: #343a40;
            
           
        }
        .table-responsive {
            margin: 10px 0;
        }
    </style>
    
    <div id="home" class="content active">
    <main class="content px-3 py-4">
        <div class="container-fluid">
            <div class="mb-3">
                <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>
                <div class="row">
                    <div class="col-12 col-md-4 ">
                        <div class="card border-1">
                            <div class="card-body py-4">
                          <h5 class="mb-2 fw">
                                    <i class="fas fa-user-plus icon-red"></i>  <small> Total donor </small>
                                </h5>
                                <p class="mb-2 fw-bold">
                                    10
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 ">
                    <div class="card border-1">
                            <div class="card-body py-4">
                                <h5 class="mb-2 fw">
                                    <i class="fas fa-tint icon-red"></i>  <small>Total blood pins collected
                                </small></h5>
                                <p class="mb-2 fw-bold">
                                    200
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 ">
                    <div class="card border-1">
                            <div class="card-body py-4">
                                <h5 class="mb-2 fw">
                                    <i class="fas fa-users icon-red"></i> <small> Total people served
    </small></h5>
                                <p class="mb-2 fw-bold">
                                    10
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 ">
                    <div class="card border-1">
                            <div class="card-body py-4">
                                <h5 class="mb-2 fw">
                                    <i class="fas fa-hand-holding-heart icon-red"></i>  <small> Total donor requests
    </small></h5>
                                <p class="mb-2 fw-bold">
                                    10
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 ">
                    <div class="card border-1">
                            <div class="card-body py-4">
                                <h5 class="mb-2 fw">
                                    <i class="fas fa-heartbeat icon-red"></i>  <small>Total blood served
    </small> </h5>
                                <p class="mb-2 fw-bold">
                                    2
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
include'view_approved_dr.php';
?>

<?php
include'view_seekers.php';
?>

<!-- Font Awesome Script -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>