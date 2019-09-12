<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $admheader ?>
<div class="col-12">
    <div class="m-content">
        <div class="row">
        	<div class="col-lg-12">
                <div class="m-portlet m-portlet--brand m-portlet--head-solid-bg">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-gift"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Промо коды
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/promo/create" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="flaticon-plus"></i>
							</a>
						</div>
					</div>
					<div class="m-portlet__body" style="padding-top: 0px;">
						<div class="m-section">
			                <div class="m-section__content">
				                <table class="table table-striped m-table">
					                <thead>
						                <tr>
							                <th><i class="flaticon-list"></i></th>
							                <th><i class="flaticon-gift"></i> Код</th>
							                <th><i class="flaticon-information"></i> Скидка</th>
							                <th><i class="flaticon-infinity"></i> Использовано</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($promos as $item): ?>
						                <tr onClick="redirect('/admin/promo/edit/index/<?php echo $item['id'] ?>')">
							                <td><?php echo $item['id'] ?></td>
							                <td><?echo $item['cod']?></td>
							                <td><?php echo $item['skidka'] ?></td>
							                <td><?php echo $item['used'] ?>/<?php echo $item['uses'] ?></td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($promos)): ?>
						                <tr>
							                <td colspan="4" class="text-center">На данный момент нет промо-кодов.</td>
						                </tr>
						                <?php endif; ?> 
					                </tbody>
				                </table>
				                <?php echo $pagination ?> 
			                </div>
			            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer ?>
