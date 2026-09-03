<template>
    <div class="modal">
        <form class="modal-content" @submit.prevent="update">
            <span class="close" @click="$emit('close')">&times;</span>
            <h3 class="title">パスワード変更</h3>
            <div class="item-group">
                <p class="label">現在のパスワード</p>
                <input class="txt" type="text" v-model="currentPassword" />
                <!-- vee-validateのバリデーション -->
                <p class="error">{{ errors.currentPassword }}</p>
                <!-- FormRequestのバリデーション -->
                <p v-if="backErrors.currentPassword" class="error">
                    {{ backErrors.currentPassword[0] }}
                </p>
            </div>
            <div class="item-group">
                <p class="label">新しいパスワード</p>
                <input class="txt" type="text" v-model="newPassword" />
                <!-- vee-validateのバリデーション -->
                <p class="error">{{ errors.newPassword }}</p>
                <!-- FormRequestのバリデーション -->
                <p v-if="backErrors.newPassword" class="error">
                    {{ backErrors.newPassword[0] }}
                </p>
            </div>
            <div class="item-group">
                <p class="label">新しいパスワード(確認)</p>
                <input class="txt" type="text" v-model="confirmPassword" />
                <!-- vee-validateのバリデーション -->
                <p class="error">{{ errors.confirmPassword }}</p>
                <!-- FormRequestのバリデーション -->
                <p v-if="backErrors.confirmPassword" class="error">
                    {{ backErrors.confirmPassword[0] }}
                </p>
            </div>
            <div class="btn-area">
                <button
                    class="update-btn"
                    type="submit"
                    v-bind:class="{
                        'is-disabled-btn': btnIsInvalid,
                    }"
                    :disabled="btnIsInvalid"
                >
                    変更する
                </button>
                <button
                    class="cancel-btn"
                    type="button"
                    @click="$emit('close')"
                >
                    キャンセル
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
// インポート
import { useForm, useField } from "vee-validate";
import * as yup from "yup";

// モーダル画面を閉じるためのイベントを定義
const emit = defineEmits(["close"]);

// バリデーションのルールを設定
const schema = yup.object({
    currentPassword: yup
        .string()
        .required("現在のパスワードを入力してください"),
    newPassword: yup
        .string()
        .required("新しいパスワードを入力してください")
        .min(6, "6文字以上で入力してください"),
    confirmPassword: yup
        .string()
        .required("新しいパスワード(確認)を入力してください")
        .oneOf([yup.ref("newPassword")], "パスワードが一致しません"),
});
// クライアントエラーを格納するオブジェクト
const { errors } = useForm({
    validationSchema: schema,
});
// エラーを格納するオブジェクト
const backErrors = ref({});
const { value: currentPassword } = useField("currentPassword");
const { value: newPassword } = useField("newPassword");
const { value: confirmPassword } = useField("confirmPassword");

// 入力したらFormRequestのバリデーションを削除する
watch([currentPassword, newPassword, confirmPassword], () => {
    backErrors.value = {};
});

// バリデーション表示の有無によって、ボタンのclassとdisabledを変更する
const btnIsInvalid = computed(() => {
    return (
        Object.keys(errors.value).length > 0 ||
        Object.keys(backErrors.value).length > 0
    );
});

// パスワード変更
const update = async () => {
    // 初期化
    backErrors.value = {};
    try {
        await apiFetch("http://localhost/api/password", {
            method: "PUT",
            body: {
                currentPassword: currentPassword.value,
                newPassword: newPassword.value,
                confirmPassword: confirmPassword.value,
            },
        });
        // モーダル画面を閉じる(パスワード変更完了のメッセージも渡す)
        emit("close", "パスワードの変更が完了しました");
        // 画面を最上部へスクロール
        window.scrollTo({
            top: 0,
            behavior: "auto",
        });
    } catch (error) {
        // ステータスコード422の場合はエラーメッセージをセット
        if (error.response && error.response.status === 422) {
            backErrors.value = error.response._data.errors;
        } else {
            // その他のエラー
            console.error("予期せぬエラーが発生しました：", error);
            alert(`予期せぬエラーが発生しました： ${error}`);
        }
    }
};
</script>

<style>
p {
    margin: 0;
}

.modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
}
.modal-content {
    background-color: #fefefe;
    padding: 40px;
    border: 1px solid #888;
    width: 55%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.title {
    margin: 0;
    font-size: 35px;
    color: #304654;
}

.item-group {
    margin-bottom: 50px;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
}

.txt {
    background-color: #f5fbff;
    font-size: 18px;
    padding: 5px;
}

.txt:focus-visible {
    background-color: #fde2e4;
}

.error {
    color: #da251d;
    text-align: left;
}

.btn-area {
    display: flex;
    justify-content: center;
}

.update-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.is-disabled-btn {
    background-color: #666666;
    opacity: 0.2;
    cursor: auto;
}

.cancel-btn {
    border: none;
    background-color: #a7a7a7;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
