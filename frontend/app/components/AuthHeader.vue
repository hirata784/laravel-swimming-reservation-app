<template>
    <div class="header">
        <h1 class="header-str">▼●▲水泳クラブ</h1>
        <nav class="header-nav">
            <button class="btn">マイページ</button>
            <div v-if="route.name === 'register'">
                <button class="btn" @click="login">ログイン</button>
            </div>
            <div v-else="route.name === 'login'">
                <button class="btn" @click="register">会員登録</button>
            </div>
        </nav>
    </div>
</template>

<script setup>
// ページのURLを取得
const route = useRoute();

// ログイン画面へ遷移
const login = () => {
    navigateTo("/login");
};

// 会員登録画面へ遷移
const register = () => {
    navigateTo("/register");
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
