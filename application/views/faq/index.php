<?php
/*
Copyright (c) 2018 HOSTINPL (HOSTING-RUS) https://vk.com/hosting_rus
Developed by Samir Shelenko (https://vk.com/id00v)
*/
?>
<?php echo $header ?>
<div class="col-lg-12">
    <div class="m-content">
        <div class="m-portlet m-portlet--full-height">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            База знаний (FAQ)
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-accordion m-accordion--default m-accordion--solid" id="m_accordion_3" role="tablist">
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_1_head" data-toggle="collapse" href="#m_accordion_3_item_1_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Ошибка FilesError</span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_1_body" role="tabpanel" aria-labelledby="m_accordion_3_item_1_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                Данная ошибка говорит о том что Вы затронули заменили или удалили бинарные файлы сервера, решается переустановкой сервера.<br>
                        Названия бинарных файлов. <br>
                        SAMP: samp03svr, samp-npc, announce. <br>
                        CRMP: samp03svr-cr, samp-npc, announcr. <br>
                        МТА SA: mta-server. <br>
                        CS 1.6: hlds_amd, hlds_i486, hlds_i686, hlds_run.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_2_head" data-toggle="collapse" href="#m_accordion_3_item_2_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Ошибка ConfigError</span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_2_body" role="tabpanel" aria-labelledby="m_accordion_3_item_2_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                Данная ошибка говорит о том что не правильно настроен конфиг (server.cfg).<br>
                        В конфиге должна быть строка bind (ip как в панели).<br>
                        Должны быть указаны параметры только те что в панели. <br>
                        maxplayers (кол-во слотов как в панели). <br>
                        port (порт как в панели).<br>
                        bind (ip как в панели).
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_3_head" data-toggle="collapse" href="#m_accordion_3_item_3_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Ошибка UnknownResponse</span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_3_body" role="tabpanel" aria-labelledby="m_accordion_3_item_3_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                    Данная ошибка решается переименовыванием сервера английскими буквами.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_4_head" data-toggle="collapse" href="#m_accordion_3_item_4_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Информация перед установкой плагинов</span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_4_body" role="tabpanel" aria-labelledby="m_accordion_3_item_4_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                    1. Устанавливайте только нужные Вам плагины.<br> 2. Слишком большое количество плагинов может вызвать увеличение пинга и лаги.<br> 3. Некоторые сочетания плагинов могут вызвать нестабильную работу сервера.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_5_head" data-toggle="collapse" href="#m_accordion_3_item_5_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Статус сервера Unknown </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_5_body" role="tabpanel" aria-labelledby="m_accordion_3_item_5_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                    Проверьте наличие плагинов .so для вашего сервера в папке plugins, а также прописаны ли они в настройках сервера.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_6_head" data-toggle="collapse" href="#m_accordion_3_item_6_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Не запускается сервер </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_6_body" role="tabpanel" aria-labelledby="m_accordion_3_item_6_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Прежде чем искать решение проблемы и писать нам в тех.поддержку в первую очередь необходимо выяснить, что за ошибка вам попалась.
Для этого вам необходимо посмотреть логи сервера и логи запуска сервера.
Это файлы server_log.txt и screenlog. Посмотреть вы их можете через ФТП, например.
В эти файлы записываются всё, что сервер отдает в командную строку. 
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_7_head" data-toggle="collapse" href="#m_accordion_3_item_7_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Ручное добавление bind в файл конфигурации </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_7_body" role="tabpanel" aria-labelledby="m_accordion_3_item_7_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Если получилось так, что вам как-то удалось заменить наш стандартный файл конфигурации на свой, где нет строки bind, или просто удалить эту строку из нашего, то для нормальной работы сервера (да и вообще для любой) стоит эту строку вернуть назад. Ваши действия:
Скачать на компьютер файл конфигурации server.cfg
Открыть файл в любом текстовом редакторе и добавить в самый конец такую строку:<br>
bind<br>
Сохранить файл<br>
Закачать файл назад по фтп с заменой старого 
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_8_head" data-toggle="collapse" href="#m_accordion_3_item_8_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">server.cfg (SAMP,CRMP) </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_8_body" role="tabpanel" aria-labelledby="m_accordion_3_item_8_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   >echo - Все, что стоит после этого параметра - будет выводится в консоль сервера при запуске. Стандартно установлено Executing Server Config...<br>
lanmode - Указывает где работает сервер, в интернете или в локальной сети, 0 для интернета. Стандартно значение установлено на 0<br>
maxplayers.<br>
announce - Включает/выключает отображение сервера в Интернете.<br>
port - Порт сервера.<br>
hostname - Название вашего сервера.<br>
gamemode(n) (N) (t) - Игровой мод<br>
weburl - Адрес вашего сайта.<br>
rcon_password - RCON пароль сервера.<br>
filterscripts (N) - Скрипты<br>
plugins (N) - Плагины<br>
password (p) - Пароль сервера<br>
mapname (m) - Название карты<br>
bind - Указывает, на каком IP адресе работает сервер. Запрещено изменять на нашем хостинге.<br>
rcon 0/1 - Включает/выключает возможность использования RCON-консоли.<br>
maxnpc - Кол-во ботов, которые могут быть использоваться на сервере.<br>
onfoot_rate - Технический параметр.<br>
incar_rate - Технический параметр.<br>
weapon_rate - Технический параметр.<br>
stream_distance - Технический параметр.<br>
stream_rate - Технический параметр.<br>
Какой будет пинг?<br>
Проверить пинг и общее качество игрового сервера вы можете на тестовых демо серверах.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_9_head" data-toggle="collapse" href="#m_accordion_3_item_9_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Как подключиться к серверу через ftp? </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_9_body" role="tabpanel" aria-labelledby="m_accordion_3_item_9_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   1. Скачать ftp-клиент, например: FileZilla<br>
2. После запуска программы необходимо указать данные от ftp-сервера, их вы получите в управлении вашего игрового сервера, в разделе "FTP Доступ".<br>
- в поле хост, введите ip-адрес сервера, с портам (21);<br>
- в поле имя пользователя, введите ваш логин от ftp;<br>
- в поле пароль, введите ваш пароль от ftp;<br>
- поле порт указать "21";<br>
3. После ввода данных, нажмите "Быстрое соединение"<br>
В правом нижнем углу загрузится структура вашего игрового сервера. Здесь вы можете устанавливать любые плагины и выполнять любые настройки своего игрового сервера.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_10_head" data-toggle="collapse" href="#m_accordion_3_item_10_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Что такое купон? </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_10_body" role="tabpanel" aria-labelledby="m_accordion_3_item_10_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Купон - это код,который вы вводите при заказе сервера,для получения скидки. (Вводить не обязательно).
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_11_head" data-toggle="collapse" href="#m_accordion_3_item_11_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Как заработать бонусы? </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_11_body" role="tabpanel" aria-labelledby="m_accordion_3_item_11_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Бонусы можно получить за:
                                   <br>
                                   За заказ сервера
                                   <br>
                                   За продление сервера
                                   <br>
                                   За докупку слотов
                                   <br>
                                   За приглашенных клиентов (вы будете получать 30 процентов от их пополнений)
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_12_head" data-toggle="collapse" href="#m_accordion_3_item_12_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Через сколько удаляется сервер если его не оплачивать? </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_12_body" role="tabpanel" aria-labelledby="m_accordion_3_item_12_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Сервер удаляется через 24 часа с момента отключения.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_13_head" data-toggle="collapse" href="#m_accordion_3_item_13_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Что такое "Бэкапы" </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_13_body" role="tabpanel" aria-labelledby="m_accordion_3_item_13_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Резервное копирование — процесс создания копии данных на носителе, предназначенном для восстановления данных в оригинальном или новом месте их расположения в случае их повреждения или разрушения.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_14_head" data-toggle="collapse" href="#m_accordion_3_item_14_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">В обязанности службы технической поддержки хостинга входит решение следующих задач </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_14_body" role="tabpanel" aria-labelledby="m_accordion_3_item_14_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Реагировать на проблемы неработоспособности функций хостинга. Предоставлять необходимую информацию касательно хостинга. Выполнять задачи поставленные клиентом (в случаи если эти задачи невозможно осуществить со стороны клиента, и эти задачи не входят в ряд дополнительных услуг.)
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_15_head" data-toggle="collapse" href="#m_accordion_3_item_15_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Не входит обязанности службы технической поддержки </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_15_body" role="tabpanel" aria-labelledby="m_accordion_3_item_15_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Устанавливать и настраивать плагины, моды, звуки, и т.д. даже в том случае, если клиент сам не в состоянии их настроить. Делать за клиента операции, которые может сделать клиент сам через FTP или Панель Управления в дальнейшем сокращёно ПУ Проводить обучение по настройке плагинов, по работе с серверами и другими услугами. Оказывать техподдержку лицам, которые не являются клиентами Хостинга. Проводить обучение по работе с серверами и другими услугами. Отвечать на вопросы которые не имеют отношения к сервисам хостинга.
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_3_item_16_head" data-toggle="collapse" href="#m_accordion_3_item_16_body" aria-expanded="false">
                            <span class="m-accordion__item-icon">
                                <i class="fa flaticon-exclamation-1"></i>
                            </span>
                            <span class="m-accordion__item-title">Важно знать и помнить </span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse" id="m_accordion_3_item_16_body" role="tabpanel" aria-labelledby="m_accordion_3_item_16_head" data-parent="#m_accordion_3" style="">
                            <div class="m-accordion__item-content">
                                <p>
                                   Хостинг не отвечает за работоспособность/стабильность Вашего сервера с установленными Вами не стандартных плагинов, карт и других файлов. Мы не несем ответственности за работоспособность сервера при Вашей самостоятельной его настройке, наша задача предоставить Вам выделенный полностью рабочий сервер. Мы не обязаны, исправлять какие либо Ваши ошибки после которых, сервер не запускается или работает нестабильно. Возможно мы сможем помочь Вам в каких-либо вопросах связанных с настройкой, но задавать их нужно во вкладке Тех.Поддержка
                               </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer ?>
