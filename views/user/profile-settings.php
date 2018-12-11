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
                                <?= date('y-m-d h:i:s e O')?>
                                <?= date('y-m-d h:i:s',strtotime(date('y-m-d h:i:s').' UTC+6'))?>
                                <?= date('y-m-d h:i:s',strtotime(date('y-m-d h:i:s')))?>
                                <?= date('y-m-d h:i:s',strtotime(date('y-m-d h:i:s')))?>
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
                                            <option timeZoneId="1" gmtAdjustment="GMT-12:00" useDaylightTime="0" value="-12">(GMT-12:00) International Date Line West</option>
                                            <option timeZoneId="2" gmtAdjustment="GMT-11:00" useDaylightTime="0" value="-11">(GMT-11:00) Midway Island, Samoa</option>
                                            <option timeZoneId="3" gmtAdjustment="GMT-10:00" useDaylightTime="0" value="-10">(GMT-10:00) Hawaii</option>
                                            <option timeZoneId="4" gmtAdjustment="GMT-09:00" useDaylightTime="1" value="-9">(GMT-09:00) Alaska</option>
                                            <option timeZoneId="5" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
                                            <option timeZoneId="6" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00) Tijuana, Baja California</option>
                                            <option timeZoneId="7" gmtAdjustment="GMT-07:00" useDaylightTime="0" value="-7">(GMT-07:00) Arizona</option>
                                            <option timeZoneId="8" gmtAdjustment="GMT-07:00" useDaylightTime="1" value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                            <option timeZoneId="9" gmtAdjustment="GMT-07:00" useDaylightTime="1" value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
                                            <option timeZoneId="10" gmtAdjustment="GMT-06:00" useDaylightTime="0" value="-6">(GMT-06:00) Central America</option>
                                            <option timeZoneId="11" gmtAdjustment="GMT-06:00" useDaylightTime="1" value="-6">(GMT-06:00) Central Time (US & Canada)</option>
                                            <option timeZoneId="12" gmtAdjustment="GMT-06:00" useDaylightTime="1" value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                            <option timeZoneId="13" gmtAdjustment="GMT-06:00" useDaylightTime="0" value="-6">(GMT-06:00) Saskatchewan</option>
                                            <option timeZoneId="14" gmtAdjustment="GMT-05:00" useDaylightTime="0" value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                            <option timeZoneId="15" gmtAdjustment="GMT-05:00" useDaylightTime="1" value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
                                            <option timeZoneId="16" gmtAdjustment="GMT-05:00" useDaylightTime="1" value="-5">(GMT-05:00) Indiana (East)</option>
                                            <option timeZoneId="17" gmtAdjustment="GMT-04:00" useDaylightTime="1" value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
                                            <option timeZoneId="18" gmtAdjustment="GMT-04:00" useDaylightTime="0" value="-4">(GMT-04:00) Caracas, La Paz</option>
                                            <option timeZoneId="19" gmtAdjustment="GMT-04:00" useDaylightTime="0" value="-4">(GMT-04:00) Manaus</option>
                                            <option timeZoneId="20" gmtAdjustment="GMT-04:00" useDaylightTime="1" value="-4">(GMT-04:00) Santiago</option>
                                            <option timeZoneId="21" gmtAdjustment="GMT-03:30" useDaylightTime="1" value="-3.5">(GMT-03:30) Newfoundland</option>
                                            <option timeZoneId="22" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Brasilia</option>
                                            <option timeZoneId="23" gmtAdjustment="GMT-03:00" useDaylightTime="0" value="-3">(GMT-03:00) Buenos Aires, Georgetown</option>
                                            <option timeZoneId="24" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Greenland</option>
                                            <option timeZoneId="25" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Montevideo</option>
                                            <option timeZoneId="26" gmtAdjustment="GMT-02:00" useDaylightTime="1" value="-2">(GMT-02:00) Mid-Atlantic</option>
                                            <option timeZoneId="27" gmtAdjustment="GMT-01:00" useDaylightTime="0" value="-1">(GMT-01:00) Cape Verde Is.</option>
                                            <option timeZoneId="28" gmtAdjustment="GMT-01:00" useDaylightTime="1" value="-1">(GMT-01:00) Azores</option>
                                            <option timeZoneId="29" gmtAdjustment="GMT+00:00" useDaylightTime="0" value="0">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
                                            <option timeZoneId="30" gmtAdjustment="GMT+00:00" useDaylightTime="1" value="0">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                                            <option timeZoneId="31" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                            <option timeZoneId="32" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                            <option timeZoneId="33" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                            <option timeZoneId="34" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                            <option timeZoneId="35" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) West Central Africa</option>
                                            <option timeZoneId="36" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Amman</option>
                                            <option timeZoneId="37" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Athens, Bucharest, Istanbul</option>
                                            <option timeZoneId="38" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Beirut</option>
                                            <option timeZoneId="39" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Cairo</option>
                                            <option timeZoneId="40" gmtAdjustment="GMT+02:00" useDaylightTime="0" value="2">(GMT+02:00) Harare, Pretoria</option>
                                            <option timeZoneId="41" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                                            <option timeZoneId="42" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Jerusalem</option>
                                            <option timeZoneId="43" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Minsk</option>
                                            <option timeZoneId="44" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Windhoek</option>
                                            <option timeZoneId="45" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
                                            <option timeZoneId="46" gmtAdjustment="GMT+03:00" useDaylightTime="1" value="3">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                            <option timeZoneId="47" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Nairobi</option>
                                            <option timeZoneId="48" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Tbilisi</option>
                                            <option timeZoneId="49" gmtAdjustment="GMT+03:30" useDaylightTime="1" value="3.5">(GMT+03:30) Tehran</option>
                                            <option timeZoneId="50" gmtAdjustment="GMT+04:00" useDaylightTime="0" value="4">(GMT+04:00) Abu Dhabi, Muscat</option>
                                            <option timeZoneId="51" gmtAdjustment="GMT+04:00" useDaylightTime="1" value="4">(GMT+04:00) Baku</option>
                                            <option timeZoneId="52" gmtAdjustment="GMT+04:00" useDaylightTime="1" value="4">(GMT+04:00) Yerevan</option>
                                            <option timeZoneId="53" gmtAdjustment="GMT+04:30" useDaylightTime="0" value="4.5">(GMT+04:30) Kabul</option>
                                            <option timeZoneId="54" gmtAdjustment="GMT+05:00" useDaylightTime="1" value="5">(GMT+05:00) Yekaterinburg</option>
                                            <option timeZoneId="55" gmtAdjustment="GMT+05:00" useDaylightTime="0" value="5">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
                                            <option timeZoneId="56" gmtAdjustment="GMT+05:30" useDaylightTime="0" value="5.5">(GMT+05:30) Sri Jayawardenapura</option>
                                            <option timeZoneId="57" gmtAdjustment="GMT+05:30" useDaylightTime="0" value="5.5">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                            <option timeZoneId="58" gmtAdjustment="GMT+05:45" useDaylightTime="0" value="5.75">(GMT+05:45) Kathmandu</option>
                                            <option timeZoneId="59" gmtAdjustment="GMT+06:00" useDaylightTime="1" value="6">(GMT+06:00) Almaty, Novosibirsk</option>
                                            <option timeZoneId="60" gmtAdjustment="GMT+06:00" useDaylightTime="0" value="6">(GMT+06:00) Astana, Dhaka</option>
                                            <option timeZoneId="61" gmtAdjustment="GMT+06:30" useDaylightTime="0" value="6.5">(GMT+06:30) Yangon (Rangoon)</option>
                                            <option timeZoneId="62" gmtAdjustment="GMT+07:00" useDaylightTime="0" value="7">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                            <option timeZoneId="63" gmtAdjustment="GMT+07:00" useDaylightTime="1" value="7">(GMT+07:00) Krasnoyarsk</option>
                                            <option timeZoneId="64" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                            <option timeZoneId="65" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Kuala Lumpur, Singapore</option>
                                            <option timeZoneId="66" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                            <option timeZoneId="67" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Perth</option>
                                            <option timeZoneId="68" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Taipei</option>
                                            <option timeZoneId="69" gmtAdjustment="GMT+09:00" useDaylightTime="0" value="9">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                            <option timeZoneId="70" gmtAdjustment="GMT+09:00" useDaylightTime="0" value="9">(GMT+09:00) Seoul</option>
                                            <option timeZoneId="71" gmtAdjustment="GMT+09:00" useDaylightTime="1" value="9">(GMT+09:00) Yakutsk</option>
                                            <option timeZoneId="72" gmtAdjustment="GMT+09:30" useDaylightTime="0" value="9.5">(GMT+09:30) Adelaide</option>
                                            <option timeZoneId="73" gmtAdjustment="GMT+09:30" useDaylightTime="0" value="9.5">(GMT+09:30) Darwin</option>
                                            <option timeZoneId="74" gmtAdjustment="GMT+10:00" useDaylightTime="0" value="10">(GMT+10:00) Brisbane</option>
                                            <option timeZoneId="75" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Canberra, Melbourne, Sydney</option>
                                            <option timeZoneId="76" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Hobart</option>
                                            <option timeZoneId="77" gmtAdjustment="GMT+10:00" useDaylightTime="0" value="10">(GMT+10:00) Guam, Port Moresby</option>
                                            <option timeZoneId="78" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Vladivostok</option>
                                            <option timeZoneId="79" gmtAdjustment="GMT+11:00" useDaylightTime="1" value="11">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                                            <option timeZoneId="80" gmtAdjustment="GMT+12:00" useDaylightTime="1" value="12">(GMT+12:00) Auckland, Wellington</option>
                                            <option timeZoneId="81" gmtAdjustment="GMT+12:00" useDaylightTime="0" value="12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                            <option timeZoneId="82" gmtAdjustment="GMT+13:00" useDaylightTime="0" value="13">(GMT+13:00) Nuku'alofa</option>
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
                                                user_timezone = '<?=$user->timezone?>',
                                                user_timezone_id = '<?=$user->timezone_id?>';
                                            $('#user_timezone_select option').each(function () {
                                                if( $(this).val() === user_timezone && $(this).attr('timeZoneId') === user_timezone_id) {
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
