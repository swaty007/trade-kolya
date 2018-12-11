<?php

$this->title = 'Мой профиль';
?>

    <div class="row wrapper border-bottom white-bg">
        <div class="col-lg-10">
            <h2><strong><?=$this->title?></strong></h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Возможности</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link binded">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link binded">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php \yii\widgets\Pjax::begin(); ?>
                                <?= Yii::$app->getFormatter()->asDatetime(time()) ?>
                                <br>
                                <?=  gmdate("Y/m/j H:i:s", time())?><br>
                                <?= date('y-m-d h:i:s e O')?><br>
                                <?= date('y-m-d h:i:s',strtotime(date('y-m-d h:i:s')))?><br>
                                <?= date('y-m-d h:i:s',strtotime(date('y-m-d h:i:s')))?><br>
                                <?= date('y-m-d h:i:s',strtotime(date('y-m-d h:i:s')))?><br>
                                <?= date_default_timezone_get()?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Юзернейм</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                               id="user_username"
                                               name="username"
                                               placeholder="placeholder"
                                               class="form-control"
                                               value="<?=$user->username?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Часовой Пояс</label>
                                    <div class="col-sm-10">
                                        <select id="user_timezone_select"
                                                name="timezone"
                                                data-placeholder="Выбор Пояса"
                                                class="chosen-select"
                                                tabindex="1">
                                            <option value="Etc/GMT+12">(GMT-12:00) International Date Line West</option>
                                            <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                                            <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
                                            <option value="US/Alaska">(GMT-09:00) Alaska</option>
                                            <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                                            <option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California</option>
                                            <option value="US/Arizona">(GMT-07:00) Arizona</option>
                                            <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                            <option value="US/Mountain">(GMT-07:00) Mountain Time (US & Canada)</option>
                                            <option value="America/Managua">(GMT-06:00) Central America</option>
                                            <option value="US/Central">(GMT-06:00) Central Time (US & Canada)</option>
                                            <option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                            <option value="Canada/Saskatchewan">(GMT-06:00) Saskatchewan</option>
                                            <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                            <option value="US/Eastern">(GMT-05:00) Eastern Time (US & Canada)</option>
                                            <option value="US/East-Indiana">(GMT-05:00) Indiana (East)</option>
                                            <option value="Canada/Atlantic">(GMT-04:00) Atlantic Time (Canada)</option>
                                            <option value="America/Caracas">(GMT-04:00) Caracas, La Paz</option>
                                            <option value="America/Manaus">(GMT-04:00) Manaus</option>
                                            <option value="America/Santiago">(GMT-04:00) Santiago</option>
                                            <option value="Canada/Newfoundland">(GMT-03:30) Newfoundland</option>
                                            <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                                            <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires, Georgetown</option>
                                            <option value="America/Godthab">(GMT-03:00) Greenland</option>
                                            <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                                            <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                                            <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                                            <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                                            <option value="Africa/Casablanca">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
                                            <option value="Etc/Greenwich">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                                            <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                            <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                            <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                            <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                            <option value="Africa/Lagos">(GMT+01:00) West Central Africa</option>
                                            <option value="Asia/Amman">(GMT+02:00) Amman</option>
                                            <option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>
                                            <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                                            <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                            <option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>
                                            <option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                                            <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                                            <option value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                            <option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>
                                            <option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
                                            <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                            <option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>
                                            <option value="Asia/Tbilisi">(GMT+03:00) Tbilisi</option>
                                            <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                                            <option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>
                                            <option value="Asia/Baku">(GMT+04:00) Baku</option>
                                            <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                            <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                            <option value="Asia/Yekaterinburg">(GMT+05:00) Yekaterinburg</option>
                                            <option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
                                            <option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                            <option value="Asia/Calcutta">(GMT+05:30) Sri Jayawardenapura</option>
                                            <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                            <option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>
                                            <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                                            <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                                            <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                            <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                                            <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                            <option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur, Singapore</option>
                                            <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                            <option value="Australia/Perth">(GMT+08:00) Perth</option>
                                            <option value="Asia/Taipei">(GMT+08:00) Taipei</option>
                                            <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                            <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                            <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                                            <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                                            <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                            <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                                            <option value="Australia/Canberra">(GMT+10:00) Canberra, Melbourne, Sydney</option>
                                            <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                                            <option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>
                                            <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                                            <option value="Asia/Magadan">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                                            <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                                            <option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                            <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Язык</label>
                                    <div class="col-sm-10">
                                        <select id="user_language_select"
                                                name="lang"
                                                data-placeholder="Выбор тегов"
                                                class="chosen-select"
                                                tabindex="1">
                                            <option value="en-EN">Английский</option>
                                            <option value="ru-RU">Русский</option>
                                        </select>
                                        <script>
                                            var user_lang = '<?=$user->lang?>',
                                                user_timezone = '<?=$user->timezone?>';
                                            $('#user_timezone_select option').each(function () {
                                                if( $(this).val() === user_timezone ) {
                                                    this.setAttribute("selected", "selected");
                                                }
                                            });
                                            $('#user_language_select option').each(function () {
                                                if( $(this).val() === user_lang ) {
                                                    this.setAttribute("selected", "selected");
                                                }
                                            });
                                            $('#user_timezone_select,#user_language_select').chosen({
                                                allow_single_deselect: true,
                                                disable_search_threshold: 10,
                                                no_results_text: 'Немає резульату по',
                                                width:"100%"
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <div class="fileContainer">
                                        <img src="<?=$user->logo_src?>" <?php if(!empty($user->logo_src)) echo "style='display: inline;'"?>>
                                        <p class="select-text <?php if(!empty($user->logo_src)) echo "hidden"?>">
                                            Select...
                                        </p>
                                        <p class="name-text <?php if(!empty($user->logo_src)) echo "loaded"?>">
                                           Аватар
                                        </p>
                                        <input id="user_avatar" type="file" name="file" accept="image/*" onchange="readURL(this);">
                                    </div>
                                </div>
                                <style>
                                    .fileContainer {
                                        cursor: pointer;
                                        overflow: hidden;
                                        position: relative;
                                        color: #4A4A4A;
                                        font-size: 13px;
                                        font-weight: 500;
                                        line-height: 16px;
                                        border: 1px solid #CFCFCF;
                                        border-radius: 3px;
                                        background-color: #CFCFCF;
                                        max-width: 300px;
                                    }
                                    .fileContainer img {
                                        height: 100px;
                                        width: 100%;
                                        object-fit: cover;
                                        display: none;
                                        opacity: 0.8;
                                    }
                                    .fileContainer .select-text {
                                        color: #ffffff;
                                        font-size: 20px;
                                        font-weight: 500;
                                        line-height: 100px;
                                        text-align: center;
                                        width: 100%;
                                    }
                                    .fileContainer .name-text {
                                        padding: 10px;
                                        background-color: #ffffff;
                                        position: relative;
                                        margin-bottom: 0;
                                    }
                                    .fileContainer .name-text.loaded:after {
                                        content: "\f046";
                                        position: absolute;
                                        color: #1ab394;
                                        right: 10px;
                                        font: normal normal normal 18px/1 FontAwesome;
                                        font-size: inherit;
                                        text-rendering: auto;
                                        -webkit-font-smoothing: antialiased;
                                    }
                                    .fileContainer [type=file] {
                                        cursor: inherit;
                                        display: block;
                                        font-size: 0;
                                        filter: alpha(opacity=0);
                                        min-height: 100%;
                                        min-width: 100%;
                                        opacity: 0;
                                        position: absolute;
                                        right: 0;
                                        text-align: right;
                                        top: 0;
                                    }
                                </style>
                                <script>
                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                $(input).siblings('img').attr('src', e.target.result).show();
                                                $(input).siblings('.select-text').hide();
                                                $(input).siblings('.name-text').addClass('loaded');
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>

                                <button id="user_update_data" class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                <?php \yii\widgets\Pjax::end(); ?>


                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Старый пароль</label>
                                    <div class="col-sm-10">
                                        <input type="password"
                                               placeholder="placeholder"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Сменить пароль</label>
                                    <div class="col-sm-10">
                                        <input type="password"
                                               placeholder="placeholder"
                                               class="form-control">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                <div class="hr-line-dashed"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
