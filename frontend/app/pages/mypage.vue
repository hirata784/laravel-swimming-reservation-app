<template>
    <div class="mypage">
        <div class="mypage-content">
            <h2 class="title">マイページ</h2>
            <div class="mypage-card">
                <p class="section-title">【次回の予約】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">予約日</p>
                        <p class="item">2026年08月03日</p>
                    </div>
                    <div class="item-group">
                        <p class="label">予約時間</p>
                        <p class="item">14:00~14:30</p>
                    </div>
                    <button class="cancel-btn" type="button">
                        予約を取り消す
                    </button>
                </div>
                <p class="section-title">【会員情報】</p>
                <div v-if="user" class="group">
                    <div class="item-group">
                        <p class="label">名前</p>
                        <p class="item">{{ user.name }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">メールアドレス</p>
                        <p class="item">{{ user.email }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">パスワード</p>
                        <p class="item">********</p>
                    </div>
                    <div class="item-group">
                        <p class="label">性別</p>
                        <p class="item">{{ user.gender }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">住所</p>
                        <p class="item">{{ user.address }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">電話番号</p>
                        <p class="item">{{ user.phone }}</p>
                    </div>
                    <div class="btn-area">
                        <button class="user-btn" type="button">
                            会員情報を変更する
                        </button>
                        <button class="password-btn" type="button">
                            パスワードを変更する
                        </button>
                    </div>
                </div>
                <p class="section-title">【予約履歴】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">予約中</p>
                        <table class="reserved-list">
                            <tbody>
                                <tr>
                                    <td>2026年08月10日</td>
                                    <td>15:30~16:00</td>
                                </tr>
                                <tr>
                                    <td>2026年08月12日</td>
                                    <td>09:00~09:30</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="item-group">
                        <p class="label">利用済み</p>
                        <table class="used-list">
                            <tbody>
                                <tr>
                                    <td>2026年07月20日</td>
                                    <td>10:00~10:30</td>
                                </tr>
                                <tr>
                                    <td>2026年07月27日</td>
                                    <td>14:00~14:30</td>
                                </tr>
                                <tr>
                                    <td>2026年07月29日</td>
                                    <td>09:00~09:30</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p class="section-title">【利用実績】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">累計利用回数</p>
                        <p class="item">3回</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// {user:データ（状態）, fetchUser: データを取得する関数 }
const { user, fetchUser } = useAuth();

// 認証中のみアクセス可能にする
definePageMeta({
    middleware: "auth",
});

// 画面構成後に処理
onMounted(async () => {
    await fetchUser();
});
</script>

<style scoped>
p {
    margin: 0;
}

.mypage {
    background-color: #cce9fa;
    width: 100%;
    text-align: center;
}

.mypage-content {
    padding: 80px 0 1px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.mypage-card {
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

.btn-area {
    display: flex;
    justify-content: center;
}

.cancel-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.user-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.password-btn {
    border: none;
    background-color: #55c6a9;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.reserved-list {
    border-collapse: collapse;
    color: #304654;
}

.used-list {
    background-color: #a7a7a7;
    border-collapse: collapse;
    color: #304654;
}

tr,
td {
    border: 1px solid #304654;
}
</style>
