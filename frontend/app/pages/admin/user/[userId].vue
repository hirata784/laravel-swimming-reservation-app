<template>
    <div class="detail">
        <div class="detail-content">
            <h2 class="title">会員詳細</h2>
            <div class="detail-card">
                <p class="section-title">【基本詳細】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">名前</p>
                        <p class="item">テスト</p>
                    </div>
                    <div class="item-group">
                        <p class="label">メールアドレス</p>
                        <p class="item">test@example.com</p>
                    </div>
                    <div class="item-group">
                        <p class="label">性別</p>
                        <p class="item">男性</p>
                    </div>
                    <div class="item-group">
                        <p class="label">住所</p>
                        <p class="item">テスト県テスト市</p>
                    </div>
                    <div class="item-group">
                        <p class="label">電話番号</p>
                        <p class="item">0001112222</p>
                    </div>
                    <div class="item-group">
                        <p class="label">登録日</p>
                        <p class="item">0000/00/00</p>
                    </div>
                </div>
                <p class="section-title">【利用状況】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">予約回数</p>
                        <p class="item">10回</p>
                    </div>
                    <div class="item-group">
                        <p class="label">利用済み</p>
                        <p class="item">7回</p>
                    </div>
                    <div class="item-group">
                        <p class="label">利用前</p>
                        <p class="item">2回</p>
                    </div>
                    <div class="item-group">
                        <p class="label">来店なし</p>
                        <p class="item">1回</p>
                    </div>
                </div>
                <p class="section-title">【予約履歴】</p>
                <div class="group">
                    <div class="item-group">
                        <table class="member-list">
                            <tbody>
                                <tr>
                                    <th>日付</th>
                                    <th>開始時間</th>
                                    <th>ステータス</th>
                                </tr>
                                <template v-for="i in 5" :key="i">
                                    <tr>
                                        <td>00/00</td>
                                        <td>10:00</td>
                                        <td>利用済み</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// ユーザーid取得
const userId = route.params.userId;

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});
</script>

<style scoped>
p {
    margin: 0;
}

.detail {
    background-color: #cce9fa;
    width: 100%;
    text-align: center;
    position: relative;
}

.detail-content {
    padding: 80px 0 1px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.detail-card {
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

.member-list {
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
</style>
