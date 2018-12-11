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
            <form {{--class="form-inline"--}}>
                <div class="form-group form-inline text-blocks">
                    <div class="text-original">
                        <textarea id="original" class="form-control" rows="14" autofocus></textarea>
                    </div>
                    <div class="corrections">
                        <div class="corrections__status">
                            <img src="{{ asset(config('settings.services_dir')) . '/' . $work->alias . '/arrow.png' }}">
                            <p title="Количество исправлений при обработке текста">
                                <span id="corrections__count">0</span><br/>
                                <span id="corrections__word">изменений</span>
                            </p>
                        </div>
                        <button id="button-copy" data-clipboard-action="copy" data-clipboard-target="#processed"
                                data-toggle="tooltip" data-placement="top" data-trigger="manual"
                                title="Скопировать обработанный текст в буфер обмена">
                            <i class="far fa-copy"></i> Готово
                        </button>
                    </div>
                    <div class="text-processed">
                        <textarea id="processed" class="form-control" rows="14" spellcheck="false" readonly></textarea>
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
                    <button id="button-check-all" title="Активировать все пункты">
                        <i class="far fa-check-square"></i>{{-- Выбрать все--}}
                    </button>
                    <button id="button-uncheck-all" title="Отключить все пункты">
                        <i class="far fa-square"></i>{{-- Отключить все--}}
                    </button>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="trailing_spaces" name="trailing_spaces" checked="checked" disabled>
                        <label class="form-check-label" for="trailing_spaces">
                            Удалить <strong>пробелы в конце</strong> и начале строк
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tab_to_space" name="tab_to_space" checked="checked">
                        <label class="form-check-label" for="tab_to_space">
                            Заменить знак <strong>табуляции</strong> на пробел
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="delete_spaces" name="delete_spaces" checked="checked">
                        <label class="form-check-label" for="delete_spaces">
                            Удалить <strong>лишние пробелы</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="add_spaces" name="add_spaces" checked="checked">
                        <label class="form-check-label" for="add_spaces">
                            Добавить <strong>недостающие пробелы</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="date_intervals" name="date_intervals" checked="checked">
                        <label class="form-check-label" for="date_intervals">
                            Правильно записать диапазоны <strong>дат</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="delete_line_breaks" name="delete_line_breaks" checked="checked">
                        <label class="form-check-label" for="delete_line_breaks">
                            Удалить лишние <strong>пустые строки</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="lowercase" name="lowercase" checked="checked">
                        <label class="form-check-label" for="lowercase">
                            Перевести предложения в нижний <strong>регистр</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tags" name="tags" checked="checked">
                        <label class="form-check-label" for="tags">
                            Убрать <strong>теги</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="number_sign" name="number_sign" checked="checked">
                        <label class="form-check-label" for="number_sign">
                            Унифицировать знак <strong>номера</strong> и сопутствующие пробелы
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="headings" name="headings">
                        <label class="form-check-label" for="headings">
                            Выделить <strong>заголовки</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="indices" name="indices" checked="checked">
                        <label class="form-check-label" for="indices">
                            Оформить верхние <strong>индексы</strong>, <strong>градусы</strong> и пр.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="soft_hyphenation" name="soft_hyphenation">
                        <label class="form-check-label" for="soft_hyphenation">
                            Проставить <strong>мягкие переносы</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="non_breaking_hyphen" name="non_breaking_hyphen" checked="checked">
                        <label class="form-check-label" for="non_breaking_hyphen">
                            Проставить <strong>неразрывные дефисы</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="punctuation" name="punctuation" checked="checked">
                        <label class="form-check-label" for="punctuation">
                            Проверить <strong>точки в конце</strong> абзацев, заголовков, сокращений
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="years" name="years" checked="checked">
                        <label class="form-check-label" for="years">
                            Заменить <strong>год (рік)</strong> на г. (р.) и добавить пропущенные
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="footnotes" name="footnotes" checked="checked">
                        <label class="form-check-label" for="footnotes">
                            Убрать <strong>сноски</strong> ([9])
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="lists" name="lists" checked="checked">
                        <label class="form-check-label" for="lists">
                            Правильная пунктуация в <strong>спискаx</strong>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="upper_first" name="upper_first" checked="checked">
                        <label class="form-check-label" for="upper_first">
                            <strong>Заглавная</strong> буква в начале абзаца
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="non_breaking_spaces" name="non_breaking_spaces" checked="checked">
                        <label class="form-check-label" for="non_breaking_spaces">
                            Проставить <strong>неразрывные пробелы</strong>
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="apostrophes" name="apostrophes" checked="checked">
                        <label class="custom-control-label" for="apostrophes">
                            Унифицировать <strong>апострофы</strong>
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="ellipsis" name="ellipsis">
                        <label class="custom-control-label" for="ellipsis">
                            Заменить <strong>многоточие</strong> одним символом
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="phone_numbers" name="phone_numbers" checked="checked">
                            <label for="phone_numbers" class="col-form-label">Преобразовать&nbsp;<strong>телефонные
                                    номера</strong>&nbsp;в&nbsp;формат:</label>
                        </div>
                        <input type="text" class="form-control" id="phone_numbers_text" name="phone_numbers_text"
                               value="(XXX) XXX-XX-XX" placeholder="+XX (XXX) XXX-XX-XX" spellcheck="false">
                    </div>
                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="quotes" name="quotes" checked="checked">
                            <label for="quotes"
                                   class="col-form-label">Изменить&nbsp;<strong>кавычки</strong>&nbsp;на&nbsp;</label>
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
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="dashes" name="dashes" checked="checked">
                            <label for="dashes"
                                   class="col-form-label">Заменить&nbsp;<strong>тире</strong>&nbsp;на&nbsp;</label>
                        </div>
                        <select class="custom-select" id="dashes_text" name="dashes_text">
                            <option selected value="\u2014">длинное: &mdash;</option>
                            <option value="\u2013">среднее: &ndash;</option>
                        </select>
                    </div>
                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="initials" name="initials" checked="checked">
                            <label for="initials"
                                   class="col-form-label">Поставить&nbsp;<strong>инициалы</strong>&nbsp;</label>
                        </div>
                        <select class="custom-select" id="initials_text" name="initials_text">
                            <option selected value="start">в начале: Т. Г. Шевченко</option>
                            <option value="end">в конце: Шевченко Т. Г.</option>
                        </select>
                    </div>

                    {{--<div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="abbreviations" checked="checked">
                            <label for="abbreviations" class="col-form-label">
                                <strong>Сокращать</strong> слова:</label>
                        </div>
                        <input type="text" class="form-control" id="abbreviations_text"
                               value="грн руб. дол. млрд млн тис. ст. табл. рис." placeholder="грн руб. дол. млрд млн тис. ст. табл. рис." spellcheck="false">
                    </div>--}}

                    <div class="form-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="abbreviations" name="abbreviations" checked="checked">
                            <label for="abbreviations" class="col-form-label">
                                <strong>Сокращать</strong> слова:</label>
                        </div>
                        <select id="abbreviations_text" {{--name="abbreviations_text[]"--}} multiple="multiple">
                            <optgroup label="Валюта" class="group-1">
                                <option value="грн" selected="selected">грн</option>
                                <option value="руб." selected="selected">руб.</option>
                                <option value="дол." selected="selected">дол. (долл.)</option>
                            </optgroup>
                            <optgroup label="Числа" class="group-2">
                                <option value="млрд" selected="selected">млрд</option>
                                <option value="млн" selected="selected">млн</option>
                                <option value="тис." selected="selected">тис.</option>
                            </optgroup>
                            <optgroup label="Публикация" class="group-3">
                                <option value="ст." selected="selected">ст. (ст.ст.)</option>
                                <option value="табл." selected="selected">табл.</option>
                                <option value="рис." selected="selected">мал. (рис.)</option>
                            </optgroup>
                        </select>
                    </div>


                    <div class="form-inline">
                        <div class="form-group form-check">
                            <input class="form-check-input" type="checkbox" id="custom_replace" name="custom_replace" checked="checked">
                            <label for="custom_replace" class="col-form-label">
                                Пользовательская замена:&nbsp;</label>
                        </div>
                        <div class="form-group">
                            <label for="custom_replace_from" class="col-form-label">
                                Найти текст:&nbsp;</label>
                            <input type="text" class="form-control" id="custom_replace_from" name="custom_replace_from"
                                   placeholder="регулярное выражение или текст" spellcheck="false">
                        </div>
                        <div class="form-group">
                            <label for="custom_replace_to" class="col-form-label">
                                Заменить на:&nbsp;</label>
                            <input type="text" class="form-control" id="custom_replace_to" name="custom_replace_to"
                                   placeholder="текст" spellcheck="false">
                        </div>
                    </div>
                </div>
            </form>
        </section>
    @endif
</div>