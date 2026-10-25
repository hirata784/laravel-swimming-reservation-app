<template>
    <div class="rewards">
        <div class="rewards-content">
            <h2 class="title">特典利用</h2>
            <form class="rewards-form" @submit.prevent="exchange">
                <p class="section-title">【使用者情報】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">名前</p>
                        <p class="item">{{ name }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">未使用特典</p>
                        <p class="item">{{ rewards }}枚</p>
                    </div>
                </div>
                <p class="section-title">【交換する商品を選択してください】</p>
                <div class="group">
                    <div
                        v-for="item in items"
                        :key="item.id"
                        class="radio-group"
                    >
                        <input
                            v-model="itemId"
                            type="radio"
                            :id="`reward-${item.id}`"
                            name="rewards"
                            :value="item.id"
                        />
                        <label class="item" :for="`reward-${item.id}`">{{
                            item.name
                        }}</label>
                    </div>
                </div>
                <div class="btn-area">
                    <button class="exchange-btn" type="submit">
                        交換を確定する
                    </button>
                    <button class="cancel-btn" type="button" @click="cancel">
                        キャンセル
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// ユーザーid取得
const userId = route.params.userId;
// ユーザー名
const name = ref("");
// 未使用特典数
const rewards = ref("");
// 選択した特典
const itemId = ref(0);
// 商品一覧
const items = ref([]);

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});

// 使用者情報の取得
const getUserInformation = async () => {
    try {
        const res = await adminApiFetch(
            `http://localhost/api/admins/user/${userId}/rewards`,
            {
                method: "GET",
            },
        );
        // 基本詳細を取得
        name.value = res.data.user.name;
        // 特典情報を取得
        rewards.value = res.data.rewards;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 交換を確定する
const exchange = async () => {
    try {
        const res = await adminApiFetch(
            `http://localhost/api/admins/user/${userId}/rewards/update`,
            {
                method: "POST",
                body: {
                    item_id: itemId.value,
                },
            },
        );
        // 会員管理画面へ遷移する
        return navigateTo("/admin/member");
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 商品一覧を取得
const getItems = async () => {
    try {
        const res = await adminApiFetch(
            "http://localhost/api/admins/reward-items/available",
            {
                method: "GET",
            },
        );

        // APIから取得した交換数の情報を画面表示用に整形
        for (let i = 0; i < res.data.items.length; i++) {
            items.value.push({
                id: res.data.items[i].id,
                name: res.data.items[i].name,
            });
        }
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// キャンセル
const cancel = () => {
    // 会員詳細画面へ遷移する
    return navigateTo(`/admin/user/${userId}`);
};

// 初回実行
getUserInformation();
getItems();
</script>

<style scoped>
p {
    margin: 0;
}

.rewards {
    background-color: #cce9fa;
    width: 100%;
    text-align: center;
    position: relative;
}

.rewards-content {
    padding: 80px 0 1px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.rewards-form {
    width: 50%;
    margin: 80px auto;
    max-width: 600px;
    padding: 30px 50px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.section-title {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
    margin-top: 20px;
}

.group {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 10px;
}

.item-group {
    margin-bottom: 30px;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.item-group:last-child {
    margin-bottom: 0;
}

.label {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
}

.item {
    font-size: 18px;
    color: #304654;
    text-align: left;
}

.radio-group {
    margin-bottom: 30px;
    width: 100%;
    display: flex;
    flex-direction: row;
}

.radio-group:last-child {
    margin-bottom: 0;
}

.btn-area {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    margin-bottom: 20px;
    height: 50px;
}

.exchange-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 35%;
}

.cancel-btn {
    border: none;
    background-color: #666666;
    opacity: 0.5;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 35%;
}
</style>
