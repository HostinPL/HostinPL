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
									<i class="flaticon-map-location"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Список локаций
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/locations/create" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
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
							                <th>Статус</th>
							                <th>Название</th>
							                <th>Пользователь</th>
							                <th>IP</th>
							                <th>CPU</th>
							                <th>RAM</th>
							                <th>SSD</th>
							                <th>Players</th>
							                <th>Uptime</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($locations as $item): ?> 
						                <tr onClick="redirect('/admin/locations/edit/index/<?php echo $item['location_id'] ?>')">
							                <th scope="row"><?php echo $item['location_id'] ?></th>
							                <td>
							                    <?php if($item['location_status'] == 0): ?> 
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Выключена</span></span>
								                <?php elseif($item['location_status'] == 1): ?> 
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Включена</span></span>
								                <?php endif; ?>
							                </td>
							                <td><?php echo $item['location_name'] ?></td>
							                <td><?php echo $item['location_user'] ?></td>
							                <td><?php echo $item['location_ip'] ?></td>
							                <td><?php echo $item['location_cpu'] ?>%</td>
							                <td><?php echo $item['location_ram'] ?>%</td>
							                <td><?php echo $item['location_hdd'] ?>mb | <?php echo $item['location_hddold'] ?>%</td>
							                <td><?php echo $item['location_players'] ?></td>
							                <td><?php echo $item['location_uptime'] ?> Дней</td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($locations)): ?> 
						                <tr>
							                <td colspan="10" class="text-center">На данный момент нет локаций.</td>
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
