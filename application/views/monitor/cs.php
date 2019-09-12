<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
<div class="m-content">
    <div class="row">
        <div class="col-lg-4">
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <?php echo $mongames ?>
                </div>
            </div>  
        </div>
        <div class="col-lg-8">
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table table-striped m-table">
                                <thead>
                                    <tr>
                                        <th><i class="flaticon-list"></i></th>
                                        <th style="text-align: center;"><i class="flaticon-notes"></i> Название</th>
                                        <th style="text-align: center;"><i class="flaticon-puzzle"></i> Игра</th>
                                        <th style="text-align: center;" width="90"><i class="flaticon-users"></i></th>
                                        <th style="text-align: center;"><i class="flaticon-placeholder"></i> Адрес</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($servers as $item): ?> 

                                <? if (!($item['server_status'] == 2 && $item['game_code'] == 'cs')) { // пропуск нечетных чисел
                        continue;
                        }?>
                                    <tr onclick="redirect('/monitor/view/index/<?echo $item['server_id']?>')">
                                        <?php if($item['server_status'] == 2) {
                                        $queryLib = new queryLibrary($item['game_query']);
                                        $queryLib->connect($item['location_ip'], $item['server_port']);
                                        $q = $queryLib->getInfo();
                                        $queryLib->disconnect();
                                        } ?>              
                                        <?if($q):?>
                                        <td>
                                            <img src="<?if($item['game_code'] == 'samp'):?>/application/public/img/monitor/samp.png
                                            <?elseif($item['game_code'] == 'cs'):?>/application/public/img/monitor/cs.png
                                            <?elseif($item['game_code'] == 'unit'):?>/application/public/img/monitor/unit.png
                                            <?elseif($item['game_code'] == 'css'):?>/application/public/img/monitor/css.png
                                            <?elseif($item['game_code'] == 'mta'):?>/application/public/img/monitor/mtasa.png
                                            <?elseif($item['game_code'] == 'crmp'):?>/application/public/img/monitor/crmp.png
                                            <?elseif($item['game_code'] == 'mine'):?>/application/public/img/monitor/samp.png
                                            <?elseif($item['game_query'] == 'mine'):?>/application/public/img/monitor/mine.png <?endif;?>" alt="" style="width: 35px; height: 35px;">
                                        </td>
                                        <td><?if($item['game_query'] == 'samp' or $item['game_query'] == 'mtasa'){ $str2 = iconv ('windows-1251', 'utf-8', $q['hostname']); echo $str2;}else{ echo $q['hostname']; }?>
                                        <p style="margin: 0;">Карта: <?if($item['game_query'] == 'samp' or $item['game_query'] == 'mtasa'){ $str2 = iconv ('windows-1251', 'utf-8', $q['mapname']); echo $str2;}else{ echo $q['mapname']; }?></p>
                                        </td>
                                        <td><?php echo $item['game_name']; if($item['user_id'] == 1){echo '';}?></td>
                                        <td style="text-align: center;" width="90"> 
                                            <div style="position: relative;"> 
                                                <div class="progress progress-striped" style="margin-bottom: 0px;"> 
                                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $q['players']*100/$q['maxplayers'] ?>%">
                                                    </div>
                                                    <div style="position: absolute;width: 100%;"><center><?php echo $q['players'] ?>/<?php echo $q['maxplayers'] ?></center>
                                                    </div> 
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $item['location_ip'] ?>:<?php echo $item['server_port'] ?><br><?php echo $item['location_name'] ?>
                                        </td>       
                                    </tr>
                                    <?endif;?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</div>
<?php echo $pagination ?>       
<?php echo $footer ?>