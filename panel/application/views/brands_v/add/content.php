<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<h4 class="m-b-lg">
                    Marka Ekle
                </h4>
			</div><!-- END column -->
			<div class="col-md-12">
				<div class="widget p-lg">
					<div class="widget-body">
						<form action="<?php echo base_url("{$viewTitle}/save") ?>" method="post" enctype = "multipart/form-data">
							<div class="form-group <?php echo isset($form_error) ? "has-error":""  ?>">
								<label for="title">Marka Başlığı</label>
								<input type="text" class="form-control" id="title" name="title">
								<?php if(isset($form_error)): ?>
								<small>Hata</small>
								<?php endif; ?>
							</div>
								<div class="form-group image_upload_container">
									<label for="exampleInputFile">Görsel Seçiniz</label>
									<input type="file" id="exampleInputFile" class="form-control" name="img_url">
								</div><!-- .form-group -->						
							<button type="submit" class="btn btn-primary btn-md btn-outline">Kaydet</button>
							<a href="<?php echo base_url("$viewTitle") ?>" class="btn btn-danger btn-md btn-outline">İptal</a>
						</form>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div><!-- END column -->
		</div><!-- .row -->
	</section><!-- #dash-content -->