<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget p-lg">
					<div class="widget-body">
						<form data-url="<?php echo base_url("{$viewTitle}/refresh_file_list/$item->id/$item->gallery_type") ?>" action="<?php echo base_url("{$viewTitle}/file_upload/$item->id/$item->gallery_type/$item->folder_name") ?>" id="dropzone" class="dropzone" data-plugin="dropzone" data-options="{ url: '<?php echo base_url("{$viewTitle}/file_upload/$item->id/$item->gallery_type/$item->folder_name") ?>'}">
							<div class="dz-message">
								<h3 class="m-h-lg">Drop files here or click to upload.</h3>
								<p class="m-b-lg text-muted">(This is just a demo dropzone. Selected files are not actually uploaded.)</p>
							</div>
						</form>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div><!-- END column -->
		</div><!-- .row -->
		<div class="row">
			<div class="col-md-12">
				<h4 class="m-b-lg">
                   <?php echo "<b>$item->title</b> adlı ürünün Fotoğraflarını Görüntüle" ?>
                </h4>
			</div><!-- END column -->
			<div class="col-md-12">
				<div class="widget p-lg">
					<div class="widget-body image_list_container">
						<?php $this->load->view("{$viewFolder}/{$subViewFolder}/render_elements/file_list_v"); ?>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div><!-- END column -->
		</div><!-- .row -->
</section><!-- #dash-content -->