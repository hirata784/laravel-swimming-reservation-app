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
                <!-- レイアウト調整用(削除不可) -->
                <div></div>
            </div>
            <!-- 予約一覧画面(ログイン) -->
            <div v-if="route.name === 'list'">
                <button class="btn" type="button">マイページ</button>
                <button class="btn" type="button" @click="logout">
                    ログアウト
                </button>
            </div>
            <!-- マイページ画面 -->
            <div v-else-if="route.name === 'mypage'">
                <button class="btn" type="button" @click="list">
                    予約一覧
                </button>
                <button class="btn" type="button" @click="logout">
                    ログアウト
                </button>
            </div>
            <div v-else>
                <button class="btn" type="button" @click="list">
                    予約一覧
                </button>
                <button class="btn" type="button">マイページ</button>
                <button class="btn" type="button" @click="logout">
                    ログアウト
                </button>
            </div>
        </nav>
        <!-- ログアウト中 -->
        <nav v-else class="header-nav">
            <div>
                <!-- レイアウト調整用(削除不可) -->
                <div></div>
            </div>
            <!-- 会員登録画面 -->
            <div v-if="route.name === 'register'">
                <button class="btn" type="button" @click="list">
                    予約一覧
                </button>
                <button class="btn" type="button" @click="login">
                    ログイン
                </button>
            </div>
            <!-- ログイン画面 -->
            <div v-else-if="route.name === 'login'">
                <button class="btn" type="button" @click="list">
                    予約一覧
                </button>
                <button class="btn" type="button" @click="register">
                    会員登録
                </button>
            </div>
            <!-- 予約一覧画面(ログアウト) -->
            <div v-else>
                <button class="btn" type="button" @click="register">
                    会員登録
                </button>
                <button class="btn" type="button" @click="login">
                    ログイン
                </button>
            </div>
        </nav>
    </div>
</template>

<script setup>
// インポート
import { watch } from "vue";

// ページのURLを取得
const route = useRoute();
// ユーザー情報取得
const user = ref("");

// ログイン状態
const token = useCookie("token");
const isLoggedIn = computed(() => {
    return !!token.value;
});

// 画面構成後に処理
onMounted(async () => {
    // tokenがある場合、ユーザー名を取得する
    if (isLoggedIn.value == true) {
        const userRes = await $fetch("http://localhost/api/auth/user", {
            headers: {
                Authorization: `Bearer ${token.value}`,
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
    // サーバー側ログアウト
    await $fetch("http://localhost/api/auth/logout", {
        method: "POST",
        headers: {
            // JWT等を使用している場合はここでAuthorizationヘッダーを渡す
            Authorization: `Bearer ${token.value}`,
        },
    });

    // クライアント側ログアウト
    token.value = null;
    // ログイン画面へ遷移する
    navigateTo("/login");
};

// 予約一覧画面へ遷移
const list = () => {
    navigateTo("/list");
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
    width: 25%;
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
