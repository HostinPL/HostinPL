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
									<i class="flaticon-tool-1"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Все категории
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/ticketcategory/create" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
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
							                <th><i class="flaticon-information"></i> Название</th>
							                <th><i class="flaticon-interface-7"></i> Статус</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($category as $item): ?>
						                <tr onClick="redirect('/admin/ticketcategory/edit/index/<?php echo $item['category_id'] ?>')">
							                <td><?php echo $item['category_id'] ?></td>
							                <td><?php echo $item['category_name'] ?></td>
							                <td>
							                	<?php if($item['category_status'] == 0): ?> 
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Выключена</span></span>
								                <?php elseif($item['category_status'] == 1): ?> 
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Включена</span></span>
								                <?php endif; ?>
								            </td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($category)): ?> 
						                <tr>
							                <td colspan="5" class="text-center">На данный момент нет категорий.</td>
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
