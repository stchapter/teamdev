jQuery(function ($) {
    //エラーを表示する関数の定義
    function show_error(message, this$) {
        this$.parent().parent().append("<p class='error'>" + message + "</p>")
    }

    $("form").submit(function () {
        //エラー表示の初期化
        $("p.error").remove();
        $("div").removeClass("error");
        var text = "";

        //1行テキスト入力フォームとテキストエリアの検証
        $(":text,textarea").filter(".validate").each(function () {

            //必須項目の検証
            $(this).filter(".required").each(function () {
                if ($(this).val() == "") {
                    show_error("※必ず入力してください。", $(this));
                }
            })

            $(this).filter(".max64").each(function () {
                if ($(this).val().length > 64) {
                    show_error("※タイトルは64文字以内で入力してください。", $(this));
                }
            })
        })

        //セレクトメニューの検証
        $("select").filter(".validate").each(function () {
            $(this).filter(".not0").each(function () {
                if ($(this).val() == 0) {
                    show_error("※必ず選択してください。", $(this));
                }
            });
        });

        //error クラスの追加の処理
        if ($("p.error").size() > 0) {
            $("p.error").parent().addClass("error");
            return false;
        }
    })

});