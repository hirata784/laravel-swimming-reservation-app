<template>
    <div class="header">
        <h1 class="header-str">▼●▲水泳クラブ</h1>
        <!-- ログイン中 -->
        <nav v-if="isLoggedIn" class="header-nav">
            <div>
                <!-- レイアウト調整用(削除不可) -->
                <div></div>
            </div>
            <!-- 予約管理画面 -->
            <div v-if="route.name === 'admin-reservations'">
                <button class="btn" type="button">会員管理</button>
                <button class="btn" type="button" @click="isLogout">
                    ログアウト
                </button>
            </div>
        </nav>
    </div>
</template>

<script setup>
// インポート
import { computed } from "vue";

// ページのURLを取得
const route = useRoute();
// { token: トークン, fetchUser: データを取得する関数, logout: ログアウト関数 }
const { token, fetchUser, logout } = useAdminAuth();
// ログイン状態
const isLoggedIn = computed(() => {
    return !!token.value;
});

// 画面構成後に処理
onMounted(async () => {
    try {
        await fetchUser();
    } catch (error) {
        try {
            await fetchUser();
        } catch {
            // クライアント側ログアウト
            token.value = null;
            // 管理者ログイン画面へ遷移する
            return navigateTo("/admin/login");
        }
    }
});

// ログアウト
const isLogout = async () => {
    await logout();
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
    width: 45%;
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
