<template>
    <div class="header">
        <h1 class="header-str">▼●▲水泳クラブ</h1>
        <nav class="header-nav">
            <button class="btn">マイページ</button>
            <div v-if="route.name === 'register'">
                <button class="btn" @click="login">ログイン</button>
            </div>
            <div v-else-if="route.name === 'login'">
                <button class="btn" @click="register">会員登録</button>
            </div>
            <div v-else="isLoggedIn">
                <button class="btn" @click="logout">ログアウト</button>
            </div>
        </nav>
    </div>
</template>

<script setup>
// インポート
import { watch } from "vue";

// ページのURLを取得
const route = useRoute();
const isLoggedIn = ref(false);

// 画面構成後に処理
onMounted(() => {
    const token = localStorage.getItem("token");
    // tokenがあればtrue, なければfalse
    isLoggedIn.value = !!token;
});

// ルートの変更を検知してリロード
watch(
    () => route.path,
    () => {
        window.location.reload();
    },
);

// ログイン画面へ遷移
const login = () => {
    navigateTo("/login");
};

// 会員登録画面へ遷移
const register = () => {
    navigateTo("/register");
};

// ログアウト
const logout = async () => {
    const token = localStorage.getItem("token");
    await $fetch("http://localhost/api/auth/logout", {
        method: "POST",
        headers: {
            // JWT等を使用している場合はここでAuthorizationヘッダーを渡す
            Authorization: `Bearer ${token}`,
        },
    });

    // ログイン取消コード
    localStorage.removeItem("token");
    isLoggedIn.value = false;
    // ログイン画面へ遷移する
    navigateTo("/login");
};
</script>

<style scoped>
p {
    margin: 0;
}

body {
    margin: 0;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #3cabe3;
    height: 10vh;
}

.header-str {
    color: #eef9ff;
    padding-left: 20px;
    margin: 0;
}

.header-nav {
    width: 20%;
    padding-right: 20px;
    display: flex;
    justify-content: space-between;
}

.btn {
    border: none;
    background-color: #3cabe3;
    color: #eef9ff;
    padding: 8px 16px;
    font-size: 20px;
    cursor: pointer;
}
</style>
