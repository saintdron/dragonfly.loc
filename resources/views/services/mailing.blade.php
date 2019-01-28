<div class="container-fluid services" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($work)
        {{-- <div style="display: none;" class="dynamic"
              data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/js/summernote.js' }}"
              data-style="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/css/summernote.css' }}"></div>--}}
        {{--<div style="display: none;" class="dynamic"
             data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/js/lang/summernote-ru-RU.js' }}"></div>--}}
        <div style="display: none;" class="dynamic"
             data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/js/fileUpload.js' }}"></div>
        <div style="display: none;" class="dynamic"
             data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/js/fileMultipleLoad.js' }}"></div>
        <div class="description_note mailing_note">
            <div class="desc_header">
                <a href="javascript:void(0)" id="description__close">X</a>
            </div>
            <div class="desc_common">
                <div class="desc_text">
                    <h2>{{ $work->title }}</h2>
                    <p>{!! $work->text !!}</p>
                </div>
                <div class="desc_meta">
                    @if($work->customer)
                        <p><strong>Заказчик:</strong> {{ $work->customer }}</p>
                    @endif
                    @if($work->techs)
                        <p><strong>Технологии:</strong> {{ $work->techs }}</p>
                    @endif
                    @if($work->created_at)
                        <p><strong>Дата:</strong> {{ $work->created_at }}</p>
                    @endif
                </div>
            </div>
            <div class="desc_demonstration">
                <img src="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/demonstration.png' }}">
            </div>
        </div>
        <section class="dynamic {{ $work->alias }}"
                 data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.js' }}"
                 data-style="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.css' }}">
            <form action="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/emaillist.php' }}"
                  method="POST" enctype="multipart/form-data" name="fileForm" id="fileForm"
                  class="form-horizontal">
                <div class="form-group">
                    {{--<label for="baseupload">Из файла <strong>.csv</strong>:</label>--}}
                    <label for="baseupload">&nbsp;</label>
                    <div class="baseupload baseupload-new" data-provides="baseupload">
                <span class="btn btn-d btn-file"><span class="baseupload-new">Выбрать из .csv</span>
                <span class="baseupload-exists">Изменить</span>
                <input type="file" name="baseupload" id="baseupload" accept=".csv"></span>
                        <span class="baseupload-preview"></span>
                        <a href="#" class="close baseupload-exists" data-dismiss="baseupload" style="float: none">×</a>
                    </div>
                </div>
            </form>
            <form action="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/testSendMail.php' }}"
                  method="POST" enctype="multipart/form-data" name="sendForm" id="sendForm"
                  class="form-horizontal">
                <div class="form-group div-first">
                    <label for="to">Кому*:</label>
                    <input type="text" class="form-control" name="to" value="" id="to">
                </div>
                <label class="help-block csv-description">Чтобы получить файл <strong>.csv</strong>, выберите в Excel
                    «Сохранить как...» и тип файла «CSV (разделители - запятые)»</label>
                <div class="form-group">
                    <label for="subject">Тема:</label>
                    <input type="text" class="form-control" name="subject" id="subject">
                </div>
                <div class="form-group bodyMail">
                    <label for="bodyMail">Тело письма*:</label>
                    <textarea class="form-control" placeholder="" name="bodyMail" id="bodyMail"></textarea>
                </div>
                <div class="form-group">
                    <div class="input-group relative-group">
                        <label class="input-group-btn">
                        <span class="btn btn-d">
                            Прикрепить файлы&hellip; <input type="file" class="fileAttach" style="display: none;"
                                                            name="fileAttachment[]" multiple>
                        </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                        <button type="button" class="close eraseAttachment" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <span class="help-block">
                    Чтобы выбрать более одного файла, зажмите <strong>Ctrl</strong>
                </span>
                </div>
                <div class="form-group div-inline">
                    <div>
                        <label for="firstname">Имя отправителя:</label>
                        <input type="text" class="form-control" name="firstname" id="firstname">
                    </div>
                    <div>
                        <label for="surname">Фамилия:</label>
                        <input type="text" class="form-control" name="surname" id="surname">
                    </div>
                    <div>
                        <label for="senderemail">E-mail*:</label>
                        <input type="text" class="form-control" name="senderEmail"
                               id="senderEmail" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="meCopy" name="meCopy" checked="checked">
                        <label class="custom-control-label" for="meCopy">
                            Отправить мне копию письма
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    {{--Статус отправки--}}
                    <div id="status" style="display: none;">
                        <div class="alert alert-danger">
                            <ul></ul>
                        </div>
                    </div>
                </div>
                <div class="bottom-group">
                    <div class="send-button">
                        <button type="submit" class="btn btn-d btn-dm" id="sendSubmit">
                            <i class="far fa-envelope"></i> Отправить письмо
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="subject">Пароль доступа (необязательно):</label>
                        <input type="password" class="form-control" name="pass" id="pass">
                    </div>
                </div>
            </form>
        </section>
    @endif
</div>