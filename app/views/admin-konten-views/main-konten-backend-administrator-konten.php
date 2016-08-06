<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
           
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $total_posting;?><sup style="font-size: 20px"></sup></h3>
                  <p>Posting Artikel dan Pemberitahuan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-pricetag-outline"></i>
                </div>
                <a href="<?php echo $url;?>list-posting" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
                           
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->