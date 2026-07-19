<template>
    <div class="header">
        <h1 class="header-str">▼●▲水泳クラブ</h1>
        <!-- ログイン中 -->
        <nav v-if="isLoggedIn">
            <div class="login-user">
                {{ user.name }}さんがログインしています
            </div>
        </nav>
        <!-- ログイン中 -->
        <nav v-if="isLoggedIn" class="header-nav">
            <div>
                <button class="btn">マイページ</button>
            </div>
            <div>
                <button class="btn" @click="logout">ログアウト</button>
            </div>
        </nav>
        <!-- ログアウト中 -->
        <nav v-else class="header-nav">
            <div>
                <!-- レイアウト調整用(削除不可) -->
                <div></div>
            </div>
            <div v-if="route.name === 'register'">
                <button class="btn" @click="login">ログイン</button>
            </div>
            <div v-else-if="route.name === 'login'">
                <button class="btn" @click="register">会員登録</button>
            </div>
            <!-- ログアウト中の予約一覧画面の場合、表示なし -->
            <div v-else>
                <div></div>
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
// ユーザー情報取得
const user = ref("");

// 画面構成後に処理
onMounted(async () => {
    const token = localStorage.getItem("token");
    // tokenがあればtrue, なければfalse
    isLoggedIn.value = !!token;
    // tokenがある場合、ユーザー名を取得する
    if (isLoggedIn.value == true) {
        const userRes = await $fetch("http://localhost/api/auth/user", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        user.value = userRes;
    }
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

.login-user {
    color: #eef9ff;
    font-size: 20px;
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
