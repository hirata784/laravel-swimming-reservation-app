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
                </div>
                <div class="group">
                    <p class="item">パスワード</p>
                    <input
                        v-model="password"
                        class="txt"
                        type="text"
                        placeholder="例：test1234"
                    />
                </div>
                <button class="login-btn">ログインする</button>
            </form>
        </div>
    </div>
</template>

<script setup>
// インポート
import { ref } from "vue";

const email = ref("");
const password = ref("");
const isLoggedIn = ref(false);

// 画面構成後に処理
onMounted(() => {
    const token = localStorage.getItem("token");
    // tokenがあればtrue, なければfalse
    isLoggedIn.value = !!token;
});

// ログイン
const isLogin = async () => {
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

    // 入力値を空白にする
    email.value = "";
    password.value = "";
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
</style>
