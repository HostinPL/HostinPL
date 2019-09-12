<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php if(!$nolog) 
{
echo $loginheader;
}else echo $header;?>
<div class="col-12">
    <div class="m-content">
        <div class="row">
			<?php
                 $nga = 0;				
				foreach($tickets as $item): ?> 
				<? if (!($item['place'] == 1)) { // пропуск нечетных чисел
                        continue;
                        }
						$nga++;?>	
						
			<?$newid = $item['news_id']?>
			<div class="col-lg-6">
				<a href="/news/view/index/<?echo $item['news_id']?>">
			    <div class="m-portlet m-portlet--skin-dark m-portlet--bordered-semi m--bg-brand">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon">
									<i class="flaticon-notes"></i>
								</span>
								<h3 class="m-portlet__head-text">
									<?php echo $item['news_title'] ?>
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<h3 class="m-portlet__head-text">
								<small><?echo $item['category_name']?></small>
							</h3>
						</div>
					</div>
					<div class="m-portlet__body">
						<?
								$string = nl2br($item['news_text']);
$string = strip_tags($string);
$string = substr($string, 0, 100);
$string = rtrim($string, "!,.-");
$string = substr($string, 0, strrpos($string, ' '));
echo $string."… ";
 
?>
						<hr>
						Опубликовано <?php echo date("d.m.Y в H:i", strtotime($item['news_date_add'])) ?>
					</div>
				</div>
			    </a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php if(!$nolog) 
{
echo $loginfooter;
}else echo $footer;?>
