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
									<i class="fa fa-gamepad"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Список игр
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<a href="/admin/games/create" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
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
							                <th><i class="flaticon-interface-7"></i> Статус</th>
							                <th><i class="flaticon-information"></i> Название</th>
							                <th><i class="flaticon-app"></i> Код</th>
							                <th><i class="flaticon-web"></i> Слоты</th>
							                <th><i class="flaticon-network"></i> Порты</th>
							                <th><i class="flaticon-piggy-bank"></i> Цена за слот</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($games as $item): ?>
						                <tr onClick="redirect('/admin/games/edit/index/<?php echo $item['game_id'] ?>')">
							                <th scope="row"><?php echo $item['game_id'] ?></th>
							                <td>
							                    <?php if($item['game_status'] == 0): ?> 
								                <span class="label label-danger">Выключена</span>
								                <?php elseif($item['game_status'] == 1): ?> 
								                <span class="label label-success">Включена</span>
								                <?php endif; ?>
							                </td>
							                <td><?php echo $item['game_name'] ?></td>
							                <td><?php echo $item['game_code'] ?></td>
							                <td><?php echo $item['game_min_slots'] ?> - <?php echo $item['game_max_slots'] ?></td>
							                <td><?php echo $item['game_min_port'] ?> - <?php echo $item['game_max_port'] ?></td>
							                <td><?php echo $item['game_price'] ?> руб.</td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($games)): ?> 
						                <tr>
							                <td colspan="7" class="text-center">На данный момент нет игр.</td>
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
