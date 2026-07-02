<template>
    <div class="register">
        <div class="register-content">
            <h2 class="title">会員登録</h2>
            <form class="register-form" @submit.prevent="addRegister">
                <div class="group">
                    <p class="item">名前</p>
                    <input
                        v-model="name"
                        class="txt"
                        type="text"
                        placeholder="例：テスト太郎"
                    />
                    <p class="error">{{ errors.name }}</p>
                </div>
                <div class="group">
                    <p class="item">メールアドレス</p>
                    <input
                        v-model="email"
                        class="txt"
                        type="text"
                        placeholder="例：test@example.com"
                    />
                    <p class="error">{{ errors.email }}</p>
                </div>
                <div class="group">
                    <p class="item">パスワード</p>
                    <input
                        v-model="password"
                        class="txt"
                        type="text"
                        placeholder="例：test1234"
                    />
                    <p class="error">{{ errors.password }}</p>
                </div>
                <!-- バリデーションの表示中はclass変更 & クリック不可 -->
                <button
                    class="register-btn"
                    v-bind:class="{
                        'is-disabled-btn': Object.keys(errors).length > 0,
                    }"
                    :disabled="Object.keys(errors).length > 0"
                >
                    登録する
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
// インポート
import { useForm, useField } from "vee-validate";
import * as yup from "yup";

// バリデーションのルールを設定
const schema = yup.object({
    name: yup
        .string()
        .required("この項目は必須です")
        .max(20, "20文字以下で入力してください"),
    email: yup
        .string()
        .required("この項目は必須です")
        .email("メールアドレスの形式で入力してください"),
    password: yup
        .string()
        .required("この項目は必須です")
        .min(6, "6文字以上入力してください"),
});

const { errors } = useForm({
    validationSchema: schema,
});

const { value: name } = useField("name");
const { value: email } = useField("email");
const { value: password } = useField("password");

// 登録
const addRegister = async () => {
    await $fetch("http://localhost/api/auth/register", {
        method: "POST",
        body: {
            name: name.value,
            email: email.value,
            password: password.value,
        },
    });

    // 入力値を空白にする
    name.value = "";
    email.value = "";
    password.value = "";
};
</script>

<style scoped>
p {
    margin: 0;
}

.register {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
}

.register-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.register-form {
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

.register-btn {
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
