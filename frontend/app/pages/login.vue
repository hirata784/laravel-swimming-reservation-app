<template>
    <div class="login">
        <div class="login-content">
            <h2 class="title">ログイン</h2>
            <form class="login-form" @submit.prevent="isLogin">
                <div class="group">
                    <p class="item">メールアドレス</p>
                    <input
                        v-model="email"
                        class="txt"
                        type="text"
                        placeholder="例：test@example.com"
                    />
                    <!-- vee-validateのバリデーション -->
                    <p class="error">{{ errors.email }}</p>
                    <!-- FormRequestのバリデーション -->
                    <p v-if="backErrors.email" class="error">
                        {{ backErrors.email[0] }}
                    </p>
                </div>
                <div class="group">
                    <p class="item">パスワード</p>
                    <input
                        v-model="password"
                        class="txt"
                        type="text"
                        placeholder="例：test1234"
                    />
                    <!-- vee-validateのバリデーション -->
                    <p class="error">{{ errors.password }}</p>
                    <!-- FormRequestのバリデーション -->
                    <p v-if="backErrors.password" class="error">
                        {{ backErrors.password[0] }}
                    </p>
                </div>
                <!-- バリデーションの表示中はclass変更 & クリック不可 -->
                <button
                    class="login-btn"
                    v-bind:class="{
                        'is-disabled-btn': btnIsInvalid,
                    }"
                    :disabled="btnIsInvalid"
                >
                    ログインする
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
// インポート
import { useForm, useField } from "vee-validate";
import * as yup from "yup";
import { ref } from "vue";

definePageMeta({
    middleware: "auth",
});

// バリデーションのルールを設定
const schema = yup.object({
    email: yup
        .string()
        .required("メールアドレスを入力してください")
        .email("メールアドレスの形式で入力してください"),
    password: yup
        .string()
        .required("パスワードを入力してください")
        .min(6, "6文字以上入力してください"),
});

const { errors } = useForm({
    validationSchema: schema,
});

const { value: email } = useField("email");
const { value: password } = useField("password");
// エラーを格納するオブジェクト
const backErrors = ref({});
const isLoggedIn = ref(false);

// 入力したらFormRequestのバリデーションを削除する
watch([email, password], () => {
    backErrors.value = {};
});

// バリデーション表示の有無によって、ボタンのclassとdisabledを変更する
const btnIsInvalid = computed(() => {
    return (
        Object.keys(errors.value).length > 0 ||
        Object.keys(backErrors.value).length > 0
    );
});

// ログイン
const isLogin = async () => {
    // 初期化
    backErrors.value = {};
    try {
        const res = await $fetch("http://localhost/api/auth/login", {
            method: "POST",
            body: {
                email: email.value,
                password: password.value,
            },
        });
        // トークンを保存
        localStorage.setItem("token", res.access_token);
        const token = localStorage.getItem("token");
        isLoggedIn.value = !!token;
        // 予約一覧画面へ移動
        navigateTo("list");
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

<style scoped>
p {
    margin: 0;
}

.login {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
}

.login-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.login-form {
    width: 60%;
    margin: 80px auto;
    padding: 30px 60px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.group {
    margin: 60px 0;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.item {
    font-size: 18px;
    color: #304654;
    text-align: left;
}

.txt {
    font-size: 18px;
    padding: 10px;
}

.error {
    color: #da251d;
    text-align: left;
    margin-top: 10px;
}

.login-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    font-size: 20px;
    cursor: pointer;
    width: 70%;
    margin-bottom: 60px;
}

.is-disabled-btn {
    background-color: #666666;
    opacity: 0.5;
    cursor: auto;
}
</style>
