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
									<i class="flaticon-coins"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Платежи пользователей
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
							                <th><i class="flaticon-list"></i></th>
							                <th><i class="flaticon-interface-7"></i> Статус</th>
							                <th><i class="flaticon-avatar"></i> Пользователь</th>
							                <th><i class="flaticon-piggy-bank"></i> Сумма</th>
							                <th><i class="flaticon-calendar-2"></i> Дата платежа</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($invoices as $item): ?>
						                <tr>
							                <th scope="row"><?php echo $item['invoice_id'] ?></th>
							                <td>
							                    <?php if($item['invoice_status'] == 0): ?> 
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Не оплачен</span></span>
							                    <?php elseif($item['invoice_status'] == 1): ?>
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Оплачен</span></span>
							                    <?php endif; ?>
							                </td>
							                <td>
							                	<a href="/admin/users/edit/index/<?php echo $item['user_id'] ?>"><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></a>
							                </td>
							                <td><?php echo $item['invoice_ammount'] ?> руб.</td>
							                <td><?php echo date("d.m.Y в H:i", strtotime($item['invoice_date_add'])) ?></td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($invoices)): ?> 
						                <tr>
							                <td colspan="5" style="text-align: center;">На данный момент нет платежей.</td>
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
