<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__container">
            <h1 class="header__title">FashionablyLate</h1>
        </div>
    </header>
    <main>
        <section class="confirm__wrapper">
            <div class="confirm__container">
                <div class="confirm-form__header">
                    <h2 class="confirm-form__header-title">Confirm</h2>
                </div>
                <div class="confirm__content">
                    <form class="confirm-form" action="/thanks" method="post">
                        @csrf
                        <table class="confirm-table" border="1">
                            {{-- 名前 --}}
                            <tr>
                                <th>お名前</th>
                                <td><input type="hidden" name="category_id" value="{{ $contact['category_id'] }}" />
                                    <input type="text" value="{{ $name }}" readonly />
                                    {{-- 送信用のお名前をhiddenで表示せずサーバーに送る --}}
                                    <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}" />
                                    <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}" />
                                </td>
                            </tr>
                            {{-- 性別 --}}
                            <tr>
                                <th>性別</th>
                                <td><input type="text" value="{{ $genderLabel[$contact['gender']] }}" readonly />
                                    {{-- 送信用の性別をhiddenで表示せずサーバーに送る --}}
                                    <input type="hidden" name="gender" value="{{ $contact['gender'] }}" />
                                </td>
                            </tr>
                            {{-- メールアドレス --}}
                            <tr>
                                <th>メールアドレス</th>
                                <td><input type="email" name="email" value="{{ $contact['email'] }}" readonly />
                                </td>
                            </tr>
                            {{-- 電話番号 --}}
                            <tr>
                                <th>電話番号</th>
                                <td><input type="tel" value="{{ $contact['tel'] }}" readonly />
                                    <input type="hidden" name="tel" value="{{ $contact['tel'] }}">
                                </td>
                            </tr>
                            {{-- 住所 --}}
                            <tr>
                                <th>住所</th>
                                <td><input type="text" name="address" value="{{ $contact['address'] }}" readonly />
                                </td>
                            </tr>
                            {{-- 建物名 --}}
                            <tr>
                                <th>建物名</th>
                                <td><input type="text" name="building" value="{{ $contact['building'] }}"
                                        readonly /></td>
                            </tr>
                            {{-- お問い合わせの種類 --}}
                            <tr>
                                <th>お問い合わせの種類</th>
                                <td><input type="text" value="{{ $category['content'] }}" readonly /></td>
                            </tr>
                            {{-- お問い合わせ内容 --}}
                            <tr>
                                <th>お問い合わせ内容</th>
                                <td>
                                    <textarea name="detail" rows="6" cols="30" readonly>{{ $contact['detail'] }}</textarea>
                                </td>
                            </tr>
                        </table>
                        <div class="button__wrapper">
                            <div class="button__wrapper-item">
                                <button class="button-submit" type="submit">送信</button>
                                <a class="link" href="/">修正</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
