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
									<i class="flaticon-users"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Список пользователей
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<button data-toggle="modal" data-target="#modal-bonus" type="button" class="btn btn-accent m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
								<i class="fa flaticon-gift"></i>
							</button>
						</div>
					</div>
					<div class="m-portlet__body" style="padding-top: 0px;">
						<div class="m-section">
			                <div class="m-section__content">
				                <table class="table table-striped m-table">
					                <thead>
						                <tr>
							                <th><i class="flaticon-list"></i></th>
							                <th><i class="flaticon-background"></i></th>
							                <th><i class="flaticon-interface-7"></i> Статус</th>
							                <th><i class="flaticon-avatar"></i> Пользователь</th>
							                <th><i class="flaticon-mail"></i> E-mail</th>
							                <th><i class="flaticon-calendar-2"></i> Дата регистрации</th>
							                <th><i class="flaticon-user-ok"></i> Статус активации</th>
						                </tr>
					                </thead>
					                <tbody>
						                <?php foreach($users as $item): ?> 
						                <tr onClick="redirect('/admin/users/edit/index/<?php echo $item['user_id'] ?>')">
							                <td scope="row"><?php echo $item['user_id'] ?></td>
							                <td><img class="todo-userpic" src="<?if($item['user_img']) {echo $item['user_img'];}else{ echo '/application/public/img/user.png';}?>" style="max-height: 25px;max-width: 25px;"></td>
							                </td>
							                <td>
							                    <?php if($item['user_status'] == 0): ?>
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Заблокирован</span></span>
							                    <?php elseif($item['user_status'] == 1): ?>
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Активен</span></span>
							                    <?php endif; ?>
							                </td>
							                <td><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></td>
							                <td><?php echo $item['user_email'] ?></td>
							                <td><?php echo date("d.m.Y", strtotime($item['user_date_reg'])) ?></td>
							                <td>
							                	<?php if($item['user_activate'] == 0): ?>
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Не подтвержден</span></span>
							                    <?php elseif($item['user_activate'] == 1): ?>
								                <span class="m-nav__link-badge"><span class="m-badge m-badge--success m-badge--wide m-badge--rounded">Подтвержден</span></span>
							                    <?php endif; ?>
							                </td>
						                </tr>
					                    <?php endforeach; ?>
						                <?php if(empty($users)): ?> 
						                <tr>
							                <td colspan="6" style="text-align: center;">На данный момент нет пользователей.</td>
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
<!--begin::Modal-->
<div class="modal fade" id="modal-bonus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Проведение акции</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form class="form-group form-md-line-input" action="#" id="sendFormBonus" method="POST">
                <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="minsum" name="minsum" placeholder="Введите минимальный бонус">
                </div>
                <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="maxsum" name="maxsum" placeholder="Введите максимальный бонус">
                </div>
                <hr>
                <div class="m-form__group form-group">
				    <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
					    <input type="checkbox" id="typesum" name="typesum"> Раздача реальных денег
					    <span></span>
				    </label>
				    <br>
				    <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
					    <input type="checkbox" id="oneuser" name="oneuser" onChange="toggleOneuser()"> Выдать только 1 пользователю
					    <span></span>
				    </label>
				    <br>
				    <label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
					    <input type="checkbox" id="createnews" name="createnews"> Создавать новость об проведённом розыгрыше
					    <span></span>
				    </label>
			    </div>
			    <hr>
			    <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="oneuserID" name="oneuserID" placeholder="Введите ID пользователя" disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary m-btn--air" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn m-btn--square btn btn-accent m-btn--air">Начать акцию</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->
<script>
	$('#sendFormBonus').ajaxForm({ 
		url: '/admin/users/index/ajax/',
		dataType: 'text',
		success: function(data) {
			console.log(data);
			data = $.parseJSON(data);
			switch(data.status) {
				case 'error':
					toastr.error(data.error);
					$('button[type=submit]').prop('disabled', false);
					document.getElementById("oneuserID").value = "";
					break;
				case 'success':
					toastr.success(data.success);
					document.getElementById("oneuserID").value = "";
					break;
				case 'info':
					toastr.info(data.info);
					document.getElementById("oneuserID").value = "";
					break;
			}	
		},
		beforeSubmit: function(arr, $form, options) {
		}
	});
	function toggleOneuser() {
		var status = $('#oneuser').is(':checked');
		if(status) {
			$('#oneuserID').prop('disabled', false);
		} else {
			$('#oneuserID').prop('disabled', true);
		}
	}
</script>						
<?php echo $footer ?>
