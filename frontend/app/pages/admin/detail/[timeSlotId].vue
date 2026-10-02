<template>
    <div class="detail">
        <div class="detail-content">
            <h2 class="title">予約詳細</h2>
            <div class="detail-form">
                <div class="week-pagination">
                    <p>10/02 10:00</p>
                </div>
                <div class="user-status">
                    <p class="user">テスト1</p>
                    <p class="status">利用済み</p>
                </div>
                <div class="user-status">
                    <p class="user">テスト2</p>
                    <p class="status">利用前</p>
                    <button class="update-btn">利用しました</button>
                </div>
                <div class="user-status">
                    <p class="user">テスト3</p>
                    <p class="status">利用済み</p>
                </div>
                <div class="user-status">
                    <p class="user">テスト4</p>
                    <p class="status">未利用</p>
                </div>
                <div class="user-status">
                    <p class="user">テスト5</p>
                    <p class="status">未利用</p>
                </div>
                <div class="user-status">
                    <p class="user">テスト6</p>
                    <p class="status">利用前</p>
                    <button class="update-btn">利用しました</button>
                </div>
                <div class="user-status">
                    <p class="user">テスト7</p>
                    <p class="status">利用前</p>
                    <button class="update-btn">利用しました</button>
                </div>
                <button class="return-btn">予約管理画面へ戻る</button>
            </div>
        </div>
    </div>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// 予約日時取得
const timeSlotId = route.params.timeSlotId;

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

.detail-form {
    width: 50%;
    max-width: 600px;
    margin: 80px auto;
    padding: 30px 50px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.week-pagination {
    display: flex;
    justify-content: space-between;
    font-size: 20px;
}

.user-status {
    display: flex;
    flex-direction: row;
    padding: 15px;
    align-items: center;
}

.user {
    width: 30%;
    font-size: 20px;
}
.status {
    width: 30%;
    font-size: 20px;
}

.update-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    cursor: pointer;
    padding: 10px 0;
    width: 30%;
    margin: 5px 0;
    font-size: 20px;
}

.return-btn {
    border: none;
    background-color: #666666;
    opacity: 0.5;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 40%;
}
</style>
