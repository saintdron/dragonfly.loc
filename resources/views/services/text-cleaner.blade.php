<div class="container-fluid services" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($work)
        <div style="display: none" class="dynamic"
             data-script="{{ asset(config('settings.extra_dir')) }}/clipboard/dist/clipboard.min.js"></div>
        <section class="dynamic {{ $work->alias }}"
                 data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.js' }}"
                 data-style="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.css' }}">
            <form {{--class="form-inline"--}}>
                <div class="form-group form-inline text-blocks">
                    <div class="text-original">
                        <textarea id="original" class="form-control" rows="14" spellcheck="false" autofocus></textarea>
                    </div>
                    <div class="corrections">
                        <div class="corrections__status">
                            <img src="{{ asset(config('settings.services_dir')) . '/' . $work->alias . '/arrow.png' }}">
                            <p title="Количество исправлений при обработке текста">
                                <span id="corrections__count">0</span><br/>
                                <span id="corrections__word">исправлений</span>
                            </p>
                        </div>
                        <button id="button-copy" data-clipboard-action="copy" data-clipboard-target="#processed"
                                title="Скопировать обработанный текст в буфер обмена">
                            <i class="fas fa-copy"></i> Готово
                        </button>
                    </div>
                    <div class="text-processed">
                        <textarea id="processed" class="form-control" rows="14"></textarea>
                    </div>
                    <div class="description">
                        <div class="desc_header">
                            <a href="javascript:void(0)" id="description__close">X</a>
                        </div>
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
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tab_to_space" checked="checked">
                        <label class="form-check-label" for="tab_to_space">
                            Заменить знак <strong>табуляции</strong> на пробел
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="delete_spaces" checked="checked">
                        <label class="form-check-label" for="delete_spaces">
                            Удалить <strong>лишние пробелы</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="add_spaces" checked="checked">
                        <label class="form-check-label" for="add_spaces">
                            Добавить <strong>недостающие пробелы</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="date_intervals" checked="checked">
                        <label class="form-check-label" for="date_intervals">
                            Правильно записать <strong>временные интервалы</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="delete_line_breaks" checked="checked">
                        <label class="form-check-label" for="delete_line_breaks">
                            Удалить повторяющиеся <strong>переносы строки</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="lowercase" checked="checked">
                        <label class="form-check-label" for="lowercase">
                            Перевести предложения в нижний <strong>регистр</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tegs" checked="checked">
                        <label class="form-check-label" for="tegs">
                            Убрать <strong>теги</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="headings" checked="checked">
                        <label class="form-check-label" for="headings">
                            Выделить <strong>заголовки</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="delete_dots_in_headers"
                               checked="checked">
                        <label class="form-check-label" for="delete_dots_in_headers">
                            Убрать <strong>точки в заголовках</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="dots_in_paragraphs" checked="checked">
                        <label class="form-check-label" for="dots_in_paragraphs">
                            Поставить <strong>точки в конце</strong> абзацев
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="years" checked="checked">
                        <label class="form-check-label" for="years">
                            Заменить <strong>год (рік)</strong> на г. (р.)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="footnotes" checked="checked">
                        <label class="form-check-label" for="footnotes">
                            Убрать <strong>сноски</strong> ([9])
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="semicolon_in_lists" checked="checked">
                        <label class="form-check-label" for="semicolon_in_lists">
                            <strong>Точка с запятой</strong> в конце пунктов списка
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="first_letter" checked="checked">
                        <label class="form-check-label" for="first_letter">
                            <strong>Заглавная</strong> буква в начале предложения
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="initials" checked="checked">
                        <label class="form-check-label" for="initials">
                            Правильно поставить <strong>инициалы</strong>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="phone_numbers" checked="checked">
                            <label for="phone_numbers" class="col-form-label">Преобразовать&nbsp;<strong>телефонные
                                    номера</strong>&nbsp;в&nbsp;формат:</label>
                        </div>
                        <input type="text" class="form-control" id="phone_numbers_text"
                               value="(XXX) XXX-XX-XX" placeholder="+38 (XXX) XXX-XX-XX" spellcheck="false">
                    </div>
                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="quotes" checked="checked">
                            <label for="quotes" class="col-form-label">Исправить&nbsp;<strong>кавычки</strong>&nbsp;на:</label>
                        </div>
                        <input type="text" class="form-control" id="quotes_text"
                               value="«»" placeholder="«»" spellcheck="false">
                    </div>
                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="dashes" checked="checked">
                            <label for="dashes" class="col-form-label">Исправить&nbsp;<strong>тире</strong>&nbsp;на:</label>
                        </div>
                        <input type="text" class="form-control" id="dashes_text"
                               value="–" placeholder="–" spellcheck="false">
                    </div>
                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="abbreviations" checked="checked">
                            <label for="abbreviations" class="col-form-label">
                                Убрать/поставить&nbsp;точки&nbsp;в&nbsp;<strong>сокращениях</strong>:</label>
                        </div>
                        <input type="text" class="form-control" id="abbreviations_text"
                               value="грн млрд млн ст. п. пп." placeholder="грн млрд млн ст. п. пп." spellcheck="false">
                    </div>

                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="abbreviations" checked="checked">
                            <label for="abbreviations" class="col-form-label">
                                Заменить * на *: (свой вариант)</label>
                        </div>
                        <input type="text" class="form-control" id="abbreviations_text"
                               value="грн млрд млн ст. п. пп." placeholder="грн млрд млн ст. п. пп." spellcheck="false">
                    </div>
                </div>
            </form>
        </section>
    @endif
</div>