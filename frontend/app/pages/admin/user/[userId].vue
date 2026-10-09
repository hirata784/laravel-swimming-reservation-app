<template>
    <div class="detail">
        <div class="detail-content">
            <h2 class="title">会員詳細</h2>
            <div class="detail-card">
                <p class="section-title">【基本詳細】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">名前</p>
                        <p class="item">{{ name }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">メールアドレス</p>
                        <p class="item">{{ email }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">性別</p>
                        <p class="item">{{ gender }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">住所</p>
                        <p class="item">{{ address }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">電話番号</p>
                        <p class="item">{{ phone }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">登録日</p>
                        <p class="item">{{ created_at }}</p>
                    </div>
                </div>
                <p class="section-title">【利用状況】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">予約回数</p>
                        <p class="item">{{ total_reservation }}回</p>
                    </div>
                    <div class="item-group">
                        <p class="label">利用済み</p>
                        <p class="item">{{ used }}回</p>
                    </div>
                    <div class="item-group">
                        <p class="label">利用前</p>
                        <p class="item">{{ reserved }}回</p>
                    </div>
                    <div class="item-group">
                        <p class="label">来店なし</p>
                        <p class="item">{{ no_show }}回</p>
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
                                <template
                                    v-for="reservation in reservations"
                                    :key="reservation"
                                >
                                    <tr>
                                        <td>{{ reservation.date }}</td>
                                        <td>{{ reservation.start_time }}</td>
                                        <td>{{ reservation.status }}</td>
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
// 基本詳細
// 名前
const name = ref("");
// メールアドレス
const email = ref("");
// 性別
const gender = ref("");
// 住所
const address = ref("");
// 電話番号
const phone = ref("");
// 登録日
const created_at = ref("");
// 利用状況
// 予約回数
const total_reservation = ref("");
// 利用済み
const used = ref("");
// 利用前
const reserved = ref("");
// 来店なし
const no_show = ref("");
// 予約データ
const reservations = ref([]);

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});

// 会員詳細の取得
const getUserDetail = async () => {
    try {
        const res = await adminApiFetch(
            `http://localhost/api/admins/user/${userId}`,
            {
                method: "GET",
            },
        );
        // 基本詳細を取得
        name.value = res.data.user.name;
        email.value = res.data.user.email;
        gender.value = res.data.user.gender;
        address.value = res.data.user.address;
        phone.value = res.data.user.phone;
        created_at.value = res.data.user.created_at;
        // 利用状況を取得
        total_reservation.value = res.data.usage.total_reservation;
        used.value = res.data.usage.used;
        reserved.value = res.data.usage.reserved;
        no_show.value = res.data.usage.no_show;
        // 予約がある場合、予約履歴を取得
        if (res.data.reservations) {
            for (let i = 0; i < res.data.reservations.length; i++) {
                reservations.value.push({
                    date: res.data.reservations[i].date,
                    start_time: res.data.reservations[i].start_time.substring(
                        0,
                        5,
                    ),
                    status: res.data.reservations[i].status,
                });
            }
        }
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 初回実行
getUserDetail();
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
