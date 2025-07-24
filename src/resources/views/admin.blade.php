<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
    <title>FasionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
</head>


<body>
    <header class="header">
        <div class="header__container">
            <h1 class="header__title">FashionablyLate</h1>
            <form class="header__form" action="/logout" method="post">
                @csrf
                <button class="header__form--logout">logout</button>
            </form>
        </div>
    </header>

    <main>
        <style>
            svg.w-5.h-5 {
                /*paginateメソッドの矢印の大きさ調整のために追加*/
                width: 30px;
                height: 30px;
            }
        </style>
        <section class="search__wrapper">
            <div class="search__container">
                <div class="search__content">
                    <div class="search-form__content">
                        <div class="search-form__header">
                            <h2 class="search-form__header-title">Admin</h2>
                        </div>
                        {{-- 検索フォーム --}}
                        <form class="search-form" action="/admin" method="get">
                            <div class="search-form__container">
                                <div class="search-form__field search-form__field--keyword">
                                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                                        placeholder="名前やメールアドレスを入力してください" />
                                </div>
                                {{-- 性別 --}}
                                <div class="search-form__field search-form__field--gender">
                                    <select name="gender">
                                        <option value="" selected hidden>性別</option>
                                        <option value="0">全て</option>
                                        <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性
                                        </option>
                                        <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性
                                        </option>
                                        <option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他
                                        </option>
                                    </select>
                                </div>
                                {{-- お問い合わせの種類 --}}
                                <div class="search-form__field search-form__field--category">
                                    <select name="category_id">
                                        <option value="0"
                                            {{ request('category_id', '0') === '0' ? 'selected' : '' }}>お問い合わせの種類
                                        </option>
                                        <option value="1" {{ request('category_id') === '1' ? 'selected' : '' }}>
                                            商品のお届けについて
                                        </option>
                                        <option value="2" {{ request('category_id') === '2' ? 'selected' : '' }}>
                                            商品の交換</option>
                                        <option value="3" {{ request('category_id') === '3' ? 'selected' : '' }}>
                                            商品トラブル</option>
                                        <option value="4" {{ request('category_id') === '4' ? 'selected' : '' }}>
                                            ショップへのお問い合わせ
                                        </option>
                                        <option value="5" {{ request('category_id') === '5' ? 'selected' : '' }}>
                                            その他</option>
                                    </select>
                                </div>
                                <div class="search-form__field search-form__field--date">
                                    <input type="date" id="search_date" name="date"
                                        value="{{ request('date') }}">
                                </div>
                                <div class="search-form__actions">
                                    <button class="search-form__button-search" type="submit">検索</button>
                                    <a class="search-form__button-reset" href="/admin">リセット</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="admin-actions">
                        {{-- エクスポートボタン --}}
                        <div class="admin-actions__export">
                            {{-- 実際にはエクスポート用フォームのボタンとして機能する --}}
                            <button type="button" class="admin-actions__button-export"
                                onclick="document.getElementById('csvExportForm').submit();">エクスポート</button>
                        </div>
                        {{-- ページネーションHTML --}}
                        <div class="pagination">
                            <ul>
                                {{-- 前へ --}}
                                @if ($contacts->onFirstPage())
                                    <li><span class="btn opt disabled"><i class="fa-solid fa-angle-left"></i></span>
                                    </li>
                                @else
                                    <li><a href="{{ $contacts->previousPageUrl() }}" class="btn opt"><i
                                                class="fa-solid fa-angle-left"></i></a></li>
                                @endif

                                {{-- ページ番号 --}}
                                @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                                    <li>
                                        <a href="{{ $contacts->url($i) }}"
                                            class="btn {{ $i == $contacts->currentPage() ? 'active' : '' }}">
                                            <p>{{ $i }}</p>
                                        </a>
                                    </li>
                                @endfor
                                {{-- 次へ --}}
                                @if ($contacts->hasMorePages())
                                    <li><a href="{{ $contacts->nextPageUrl() }}" class="btn opt"><i
                                                class="fa-solid fa-angle-right"></i></a></li>
                                @else
                                    <li><span class="btn opt disabled"><i class="fa-solid fa-angle-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    {{-- ステータスメッセージ --}}
                    <div class="status">
                        @if (session('message'))
                            <div class="status__message">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>
                    {{-- 検索結果テーブル --}}
                    <div class="search-result__container">
                        <div class="search-result">
                            @if ($contacts->count())
                                <table class="search-result__table">
                                    <thead>
                                        <tr>
                                            <th>お名前</th>
                                            <th>性別</th>
                                            <th>メールアドレス</th>
                                            <th>お問い合わせの種類</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr>
                                                <td>{{ $contact->last_name }} {{ $contact->first_name }} </td>
                                                <td>
                                                    @if ($contact->gender == 1)
                                                        男性
                                                    @elseif($contact->gender == 2)
                                                        女性
                                                    @else
                                                        その他
                                                    @endif
                                                </td>
                                                <td>{{ $contact->email }} </td>
                                                <td>{{ $contact->category->content }} </td>

                                                {{-- 詳細ボタン --}}
                                                <td>
                                                    <button type="button" class="openModalBtn"
                                                        data-id="{{ $contact->id }}"
                                                        data-name="{{ $contact->last_name }} {{ $contact->first_name }}"
                                                        data-gender="{{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}"
                                                        data-email="{{ $contact->email }}"
                                                        data-tel="{{ $contact->tel }}"
                                                        data-address="{{ $contact->address }}"
                                                        data-building="{{ $contact->building }}"
                                                        data-category="{{ $contact->category->content }}"
                                                        data-detail="{{ $contact->detail }}">
                                                        詳細
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>該当するデータはありません</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- CSVエクスポート用のフォーム --}}
    <form id="csvExportForm" action="/admin/export" method="post">
        @csrf
        {{-- 検索条件をそのまま引き継ぎ --}}
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
        <input type="hidden" name="gender" value="{{ request('gender') }}">
        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
    </form>


    {{-- モーダル --}}
    <div id="modal" class="modal" style="display:none;">
        <div class="modal__content">
            <span id="closeModal" class="modal__close">&times;</span>
            <table class="info-table">
                <tr>
                    <td>お名前</td>
                    <td id="modal-name"></td>
                </tr>
                <tr>
                    <td>性別</td>
                    <td id="modal-gender"></td>
                </tr>
                <tr>
                    <td>メールアドレス</td>
                    <td id="modal-email"></td>
                </tr>
                <tr>
                    <td>電話番号</td>
                    <td id="modal-tel"></td>
                </tr>
                <tr>
                    <td>住所</td>
                    <td id="modal-address"></td>
                </tr>
                <tr>
                    <td>建物名</td>
                    <td id="modal-building"></td>
                </tr>
                <tr>
                    <td>お問い合わせの種類</td>
                    <td id="modal-category"></td>
                </tr>
                <tr>
                    <td>お問い合わせ内容</td>
                    <td id="modal-detail"></td>
                </tr>
            </table>
            <div style="text-align:center; margin-top:15px;">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">削除</button>
                </form>
            </div>
        </div>
        {{-- モーダルここまで --}}
        <script>
            const modal = document.getElementById('modal');
            const closeBtn = document.getElementById('closeModal');
            const openButtons = document.querySelectorAll('.openModalBtn');
            const deleteForm = document.getElementById('deleteForm');

            // モーダル内の要素を取得
            const modalName = document.getElementById('modal-name');
            const modalGender = document.getElementById('modal-gender');
            const modalEmail = document.getElementById('modal-email');
            const modalTel = document.getElementById('modal-tel');
            const modalAddress = document.getElementById('modal-address');
            const modalBuilding = document.getElementById('modal-building');
            const modalCategory = document.getElementById('modal-category');
            const modalDetail = document.getElementById('modal-detail');

            // すべての詳細ボタンにイベントを追加
            openButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // data-* 属性から値を取得してモーダルにセット
                    modalName.textContent = button.dataset.name;
                    modalGender.textContent = button.dataset.gender;
                    modalEmail.textContent = button.dataset.email;
                    modalTel.textContent = button.dataset.tel;
                    modalAddress.textContent = button.dataset.address;
                    modalBuilding.textContent = button.dataset.building;
                    modalCategory.textContent = button.dataset.category;
                    modalDetail.textContent = button.dataset.detail;

                    // 削除用フォームのaction動的設定
                    const contactId = button.dataset.id;
                    deleteForm.action = `/admin/contacts/${contactId}`;

                    // モーダル表示
                    modal.style.display = 'block';
                });
            });

            // 閉じるボタン
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // 背景クリックで閉じる
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        </script>
</body>

</html>
