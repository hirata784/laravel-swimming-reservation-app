<template>
    <div class="confirm">
        <div class="confirm-content">
            <h2 class="title">予約内容の確認</h2>
            <form
                class="confirm-form"
                @submit.prevent="addReservation(user, date, time)"
            >
                <p class="section-title">【ご予約者情報】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">名前</p>
                        <p class="item">{{ user.name }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">メールアドレス</p>
                        <p class="item">{{ user.email }}</p>
                    </div>
                </div>
                <p class="section-title">【予約内容】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">予約日</p>
                        <p class="item">{{ displayDate }}</p>
                    </div>
                    <div class="item-group">
                        <p class="label">予約時間</p>
                        <p class="item">{{ time }}</p>
                    </div>
                </div>
                <div class="btn-area">
                    <button class="reservation-btn" type="submit">
                        予約する
                    </button>
                    <button class="return-btn" type="button" @click="list">
                        予約一覧へ戻る
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
// useRoute呼び出し
const route = useRoute();
// 予約日時取得
const date = route.params.date;
const time = route.params.time;
// 年月日表示用
const year = date.substring(0, 4);
const month = date.substring(5, 7);
const dates = date.substring(8, 10);
const displayDate = `${year}年${month}月${dates}日`;
// ユーザー情報取得
const user = ref("");
// トークン取得
const token = useCookie("token");

// 画面構成後に処理
onMounted(async () => {
    const userRes = await $fetch("http://localhost/api/auth/user", {
        headers: {
            Authorization: `Bearer ${token.value}`,
        },
    });
    user.value = userRes;
});

// 予約一覧画面へ遷移
const list = () => {
    navigateTo("/list");
};

// 予約の処理を行う
const addReservation = async (user, date, time) => {
    await $fetch("http://localhost/api/reservation", {
        method: "POST",
        body: {
            user_id: user.id,
            date: date,
            start_time: time,
        },
    });
    // 予約一覧画面へ遷移
    navigateTo("/list");
};
</script>

<style scoped>
p {
    margin: 0;
}

.confirm {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
}

.confirm-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.confirm-form {
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
    margin-top: 30px;
    margin-bottom: 20px;
    height: 50px;
}

.reservation-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 35%;
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
    width: 35%;
}
</style>
