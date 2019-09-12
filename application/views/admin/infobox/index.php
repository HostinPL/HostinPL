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
									<i class="flaticon-speech-bubble"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Обратная связь
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body" style="padding-top: 0px;">
						<div class="m-section">
			                <div class="m-section__content">
				                <table class="table table-striped m-table">
					                <thead>
						                <tr>
						                	<th><i class="flaticon-avatar"></i> Отправитель</th>
							                <th><i class="flaticon-book"></i> Тема</th>
							                <th><i class="flaticon-multimedia-5"></i> E-mail</th>
							                <th><i class="flaticon-calendar-2"></i> Дата обращения</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($mail as $item): ?>
						                <tr onClick="redirect('/admin/infobox/send/index/<?php echo $item['id']?>')">
							                <th scope="row"><?php echo $item['user_lastname'] ?> <?php echo $item['user_firstname'] ?></th>
							                <td><?php echo $item['category']?></td>
							                <td><?php echo $item['user_email'] ?></td>
							                <td><?php echo $item['inbox_date_add']?></td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($mail)): ?> 
						                <tr>
							                <td colspan="5" style="text-align: center;">На данный момент нет запросов.</td>
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
