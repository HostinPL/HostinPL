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
									<i class="flaticon-open-box"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Список дополнений
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/adaps/create" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
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
							                <th><i class="fa fa-gamepad"></i> Игра</th>
							                <th><i class="flaticon-information"></i> Название</th>
							                <th><i class="flaticon-interface-7"></i> Статус</th>
							                <th><i class="flaticon-piggy-bank"></i> Стоимость</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($adaps as $item): ?>
						                <tr onClick="redirect('/admin/adaps/edit/index/<?php echo $item['adap_id'] ?>')">
							                <th scope="row"><?php echo $item['adap_id'] ?></th>
							                <td><?php echo $item['game_name'] ?></td>
							                <td><?php echo $item['adap_name'] ?></td>
							                <td>
							                    <?php if($item['adap_status'] == 0): ?> 
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Выключен</span></span>
								                <?php elseif($item['adap_status'] == 1): ?> 
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Включен</span></span>
								                <?php endif; ?>
							                </td>
							                <td><?php echo $item['adap_price'] ?></td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($adaps)): ?> 
						                <tr>
							                <td colspan="4" class="text-center">На данный момент нет дополнений.</td>
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
