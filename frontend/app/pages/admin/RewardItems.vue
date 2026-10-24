<template>
    <div class="list">
        <div class="list-content">
            <h2 class="title">商品別の交換数</h2>
            <div class="list-card">
                <p class="section-title">【交換実績の概要】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">登録商品数</p>
                        <p class="item">{{ registered_count }}つ</p>
                    </div>
                    <div class="item-group">
                        <p class="label">累計交換数</p>
                        <p class="item">{{ total_exchange_count }}回</p>
                    </div>
                </div>
                <p class="section-title">【商品別の交換実績】</p>
                <div class="group">
                    <div class="item-group">
                        <table class="item-list">
                            <tbody>
                                <tr>
                                    <th>商品名</th>
                                    <th>交換回数</th>
                                </tr>
                                <template v-for="item in items" :key="item.id">
                                    <tr>
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.exchange_count }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="return-btn" type="button">
                    予約管理画面へ戻る
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
// 商品交換数
const items = ref([]);
// 登録商品数
const registered_count = ref(0);
// 累計交換数
const total_exchange_count = ref(0);

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});

// 商品の交換数
const getItems = async () => {
    try {
        const res = await adminApiFetch(
            "http://localhost/api/admins/reward-items",
            {
                method: "GET",
            },
        );

        // APIから取得した交換数の情報を画面表示用に整形
        for (let i = 0; i < res.data.items.length; i++) {
            items.value.push({
                id: res.data.items[i].id,
                name: res.data.items[i].name,
                exchange_count: res.data.items[i].exchange_count,
            });
        }
        // 登録商品数
        registered_count.value = res.data.registered_count;
        // 累計交換数
        total_exchange_count.value = res.data.total_exchange_count;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 初回実行
getItems();
</script>

<style scoped>
p {
    margin: 0;
}

.list {
    background-color: #cce9fa;
    width: 100%;
    text-align: center;
    position: relative;
}

.list-content {
    padding: 80px 0 1px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.list-card {
    width: 50%;
    max-width: 600px;
    margin: 80px auto;
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

.item-list {
    width: 100%;
    margin: 0 auto;
    text-align: center;
    border-collapse: collapse;
    border: 1px solid #304654;
    color: #304654;
    font-size: 20px;
}

tr,
th,
td {
    border-bottom: 1px solid #304654;
    text-align: left;
    padding: 5px;
}

.return-btn {
    border: none;
    background-color: #666666;
    opacity: 0.5;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 30px 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 40%;
}
</style>
