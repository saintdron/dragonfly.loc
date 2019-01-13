<div class="container-fluid services" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($work)
        {{--<div style="display: none" class="dynamic"
             data-script="{{ asset(config('settings.extra_dir')) }}/clipboard/dist/clipboard.min.js"></div>--}}
        {{--<div style="display: none" class="dynamic"
         data-script="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></div>--}}
        <section class="dynamic {{ $work->alias }}"
                 data-script="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.js' }}"
                 data-style="{{ asset(config('settings.services_dir')). '/' . $work->alias . '/' . $work->alias . '.css' }}">
            <form>
                <div class="main-container">
                    <div class="main-block">
                        <div class="form-group form-inline text-blocks">
                            <div class="text-original">
                                <textarea id="original" class="form-control" autofocus></textarea>
                            </div>
                            <div class="corrections">
                                <div class="corrections__status">
                                    <img src="{{ asset(config('settings.services_dir')) . '/' . $work->alias . '/arrow.png' }}">
                                    <p title="Количество исправлений при обработке текста">
                                        <span id="corrections__count">0</span><br/>
                                        <span id="corrections__word">изменений</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-processed">
                                <textarea id="processed" class="form-control" spellcheck="false" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group form-inline buttons-block">
                            <button class="btn-d" id="button-check-all" title="Активировать все пункты">
                                <i class="far fa-check-square"></i>
                            </button>
                            <button class="btn-d" id="button-uncheck-all" title="Отключить все пункты">
                                <i class="far fa-square"></i>
                            </button>
                            <button class="btn-d" id="button-copy" data-clipboard-action="copy"
                                    data-clipboard-target="#processed"
                                    data-toggle="tooltip" data-placement="left" data-trigger="manual"
                                    title="Скопировать обработанный текст в буфер обмена">
                                <i class="far fa-copy"></i> Скопировать
                            </button>
                        </div>
                    </div>
                    <div class="description_note">
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

                <div class="grouping">
                    <div class="group-1">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="trailing_spaces"
                                       name="trailing_spaces"
                                       checked="checked" disabled>
                                <label class="custom-control-label" for="trailing_spaces">
                                    Удалить <strong>ведущие и замыкающие пробелы</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_line_breaks"
                                       name="delete_line_breaks" checked="checked">
                                <label class="custom-control-label" for="delete_line_breaks">
                                    Удалить <strong>пустые строки</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="tab_to_space"
                                       name="tab_to_space"
                                       checked="checked">
                                <label class="custom-control-label" for="tab_to_space">
                                    Заменить <strong>табуляцию</strong> на пробел
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_spaces"
                                       name="delete_spaces"
                                       checked="checked">
                                <label class="custom-control-label" for="delete_spaces">
                                    Удалить <strong>лишние пробелы</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="add_spaces"
                                       name="add_spaces"
                                       checked="checked">
                                <label class="custom-control-label" for="add_spaces">
                                    Добавить <strong>недостающие пробелы</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="non_breaking_spaces"
                                       name="non_breaking_spaces" checked="checked">
                                <label class="custom-control-label" for="non_breaking_spaces">
                                    Проставить <strong>неразрывные пробелы</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="non_breaking_hyphen"
                                       name="non_breaking_hyphen" checked="checked">
                                <label class="custom-control-label" for="non_breaking_hyphen">
                                    Проставить <strong>неразрывные дефисы</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="soft_hyphenation"
                                       name="soft_hyphenation">
                                <label class="custom-control-label" for="soft_hyphenation">
                                    Проставить <strong>мягкие переносы</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="headings" name="headings">
                                <label class="custom-control-label" for="headings">
                                    Выделить <strong>заголовки</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="punctuation"
                                       name="punctuation"
                                       checked="checked">
                                <label class="custom-control-label" for="punctuation">
                                    Проверить <strong>точки</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="lists" name="lists"
                                       checked="checked">
                                <label class="custom-control-label" for="lists">
                                    Поправить <strong>списки</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="group-2">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="lowercase" name="lowercase"
                                       checked="checked">
                                <label class="custom-control-label" for="lowercase">
                                    Перевести предложения в нижний <strong>регистр</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="upper_first"
                                       name="upper_first"
                                       checked="checked">
                                <label class="custom-control-label" for="upper_first">
                                    Сделать первую букву абзаца <strong>заглавной</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="date_intervals"
                                       name="date_intervals"
                                       checked="checked">
                                <label class="custom-control-label" for="date_intervals">
                                    Правильно записать диапазоны <strong>дат</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="number_sign"
                                       name="number_sign"
                                       checked="checked">
                                <label class="custom-control-label" for="number_sign">
                                    Унифицировать знак <strong>номера</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="indices" name="indices"
                                       checked="checked">
                                <label class="custom-control-label" for="indices">
                                    Оформить верхние <strong>индексы</strong>, <strong>градусы</strong> и пр.
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="apostrophes"
                                       name="apostrophes"
                                       checked="checked">
                                <label class="custom-control-label" for="apostrophes">
                                    Унифицировать <strong>апострофы</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="years" name="years"
                                       checked="checked">
                                <label class="custom-control-label" for="years">
                                    Сократить или добавить <strong>г. (р.)</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="tags" name="tags"
                                       checked="checked">
                                <label class="custom-control-label" for="tags">
                                    Убрать <strong>теги</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="html_entities"
                                       name="html_entities"
                                       checked="checked">
                                <label class="custom-control-label" for="html_entities">
                                    Заменить <strong>HTML-сущности</strong>
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="footnotes" name="footnotes"
                                       checked="checked">
                                <label class="custom-control-label" for="footnotes">
                                    Убрать <strong>сноски</strong> ([9])
                                </label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="ellipsis" name="ellipsis"
                                       checked="checked">
                                <label class="custom-control-label" for="ellipsis">
                                    Заменить <strong>многоточие</strong> одним символом
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="group-3">
                    <div class="form-group">
                        <div class="form-inline">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="phone_numbers"
                                       name="phone_numbers"
                                       checked="checked">
                                <label for="phone_numbers" class="custom-control-label">
                                    <strong>Телефонные номера</strong>&nbsp;в&nbsp;формат:
                                </label>
                            </div>
                            <input type="text" class="form-control" id="phone_numbers_text" name="phone_numbers_text"
                                   value="(XXX) XXX-XX-XX" placeholder="+XX (XXX) XXX-XX-XX" spellcheck="false">
                        </div>
                        <div class="form-inline">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="quotes" name="quotes"
                                       checked="checked">
                                <label for="quotes"
                                       class="custom-control-label">Заменить&nbsp;<strong>кавычки</strong>&nbsp;на</label>
                            </div>
                            <select class="custom-select" id="quotes_text" name="quotes_text">
                                <option selected value="\u00ab\u00bb">&laquo;ёлочки&raquo;</option>
                                <option value="\u201e\u201c">&#8222;лапки&#8220;</option>
                                <option value="\u201c\u201d">&#8220;английские двойные&#8221;</option>
                                <option value="\u2018\u2019">&#8216;английские одиночные&#8217;</option>
                                <option value="\u00bb\u00ab">&raquo;шведские&laquo;</option>
                                <option value="\u0022\u0022">&#34;двойные&#34;</option>
                                <option value="\u0027\u0027">&#39;апострофы&#39;</option>
                            </select>
                        </div>
                        <div class="form-inline">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="dashes" name="dashes"
                                       checked="checked">
                                <label for="dashes"
                                       class="custom-control-label">Заменить&nbsp;<strong>тире</strong>&nbsp;на</label>
                            </div>
                            <select class="custom-select" id="dashes_text" name="dashes_text">
                                <option selected value="\u2014">длинное: &mdash;</option>
                                <option value="\u2013">среднее: &ndash;</option>
                            </select>
                        </div>
                        <div class="form-inline">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="initials" name="initials"
                                       checked="checked">
                                <label for="initials"
                                       class="custom-control-label">Поставить&nbsp;<strong>инициалы</strong></label>
                            </div>
                            <select class="custom-select" id="initials_text" name="initials_text">
                                <option selected value="start">в начале: Т. Г. Шевченко</option>
                                <option value="end">в конце: Шевченко Т. Г.</option>
                            </select>
                        </div>
                        <div class="form-inline">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="abbreviations"
                                       name="abbreviations"
                                       checked="checked">
                                <label for="abbreviations" class="custom-control-label">
                                    <strong>Сокращать</strong>&nbsp;слова:</label>
                            </div>
                            <select id="abbreviations_text" multiple="multiple">
                                <optgroup label="Валюта" class="group-1">
                                    <option value="грн">грн</option>
                                    <option value="руб.">руб.</option>
                                    <option value="дол.">дол. (долл.)</option>
                                </optgroup>
                                <optgroup label="Числа" class="group-2">
                                    <option value="млрд">млрд</option>
                                    <option value="млн">млн</option>
                                    <option value="тис.">тис.</option>
                                </optgroup>
                                <optgroup label="Публикация" class="group-3">
                                    <option value="ст.">ст. (ст.ст.)</option>
                                    <option value="табл.">табл.</option>
                                    <option value="мал.">мал. (рис.)</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="group-4">
                    <div class="form-group custom-control custom-checkbox">
                        <div class="c-replace">
                            <input class="custom-control-input" type="checkbox" id="custom_replace"
                                   name="custom_replace"
                                   checked="checked">
                            <label for="custom_replace" class="custom-control-label">
                                Пользовательская&nbsp;<strong>замена</strong>:
                            </label>
                        </div>
                        <div class="c-replace-from">
                            <label for="custom_replace_from" class="col-form-label">
                                Найти текст:
                            </label>
                            <input type="text" class="form-control" id="custom_replace_from"
                                   name="custom_replace_from"
                                   placeholder="регулярное выражение или текст" spellcheck="false">
                        </div>
                        <div class="c-replace-to">
                            <label for="custom_replace_to" class="col-form-label">
                                Заменить на:
                            </label>
                            <input type="text" class="form-control" id="custom_replace_to"
                                   name="custom_replace_to"
                                   placeholder="текст" spellcheck="false">
                        </div>
                    </div>
                </div>
            </form>
            <div class="attention alert alert-warning" role="alert">
                <h5>Обратите внимание!</h5>
                <p>Если текст копируется из PDF, то файл необходимо предварительно открыть любым браузером (за
                    исключением Firefox). В&nbsp;ином случае переносы воспринимаются как дефисы, и&nbsp;нет возможности
                    их различить.</p>
                <p>Опцию «Проставить мягкие переносы» используйте только для верстальных программ.</p>
                <p>Если вы заметили ошибку или у вас есть предложение по улучшению данной программы, пожалуйста,
                    используйте
                    <a href="{{ route('cv') . '#feedback' }}">форму&nbsp;обратной&nbsp;связи</a>.</p>
            </div>
        </section>
    @endif
</div>