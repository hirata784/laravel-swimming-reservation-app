<template>
    <div class="detail">
        <div class="detail-content">
            <h2 class="title">予約詳細</h2>
            <div class="detail-form">
                <div class="week-pagination">
                    <p>{{ formatDate(date) }}{{ formatTime(time) }}</p>
                </div>
                <!-- 予約者がいない場合 -->
                <p v-if="userStatus.length === 0">
                    この時間枠に予約者はいません
                </p>
                <div
                    v-for="user in userStatus"
                    :key="user.reservation_id"
                    class="user-status"
                >
                    <p class="user">{{ user.name }}</p>
                    <!-- statusがreserved(利用前)の場合 -->
                    <div v-if="user.status === 'reserved'" class="group">
                        <p class="status">利用前</p>
                        <button
                            type="button"
                            @click="usedStatus(user.reservation_id)"
                            class="update-btn"
                        >
                            利用しました
                        </button>
                    </div>
                    <!-- statusがused(利用済み)の場合 -->
                    <div v-else-if="user.status === 'used'" class="group">
                        <p class="status">利用済み</p>
                        <button
                            type="button"
                            @click="reservedStatus(user.reservation_id)"
                            class="cancel-btn"
                        >
                            利用前に戻す
                        </button>
                    </div>
                </div>
                <button class="return-btn" type="button" @click="reservations">
                    予約管理画面へ戻る
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
// インポート
import { ref } from "vue";

// useRoute呼び出し
const route = useRoute();
// 予約日時
const timeSlotId = route.params.timeSlotId;
// 年月日
const date = ref("");
// 時間
const time = ref("");
// 予約者
const userStatus = ref([]);
// 今日の日付を取得
const today = new Date();
// 今年
const y = today.getFullYear();
// 今月(1~9月は頭を0で埋める(例：01月))
const m = (today.getMonth() + 1).toString().padStart(2, "0");
// 日付
const d = today.getDate().toString().padStart(2, "0");
// 現在の年月日
const currentDate = `${y}-${m}-${d}`;

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});

// 年月日フォーマット変更(例：2026年08月14日)
const formatDate = (dateString) => {
    // 空データ時のガード句（バグ防止）
    if (!dateString) return "";
    // 日付文字列をDateオブジェクトに変換
    const d = new Date(dateString);

    // 取得した日付から年・月・日を抽出して0埋め
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, "0");
    const dd = String(d.getDate()).padStart(2, "0");

    return `${yyyy}年${mm}月${dd}日`;
};

// 時間フォーマット変更(例：予約時間~予約時間+30分)
const formatTime = (dateString) => {
    // 空データ時のガード句（バグ防止）
    if (!dateString) return "";

    // 時間を取得
    const h = dateString.substring(0, 2);
    // 分を取得
    const m = dateString.substring(3, 5);

    // 本日の日付を取得
    const t = new Date();
    // 時間と分をセット(秒とミリ秒は0にリセット)
    t.setHours(h, m, 0, 0);
    // 現在の分に30分を足す（15:30+30分=16:00に自動繰り上げ）
    t.setMinutes(t.getMinutes() + 30);
    // 30分後の表記を取得
    const finishTime = `${t.getHours().toString().padStart(2, "0")}:${t.getMinutes().toString().padStart(2, "0")}`;

    return `${dateString}~${finishTime}`;
};

// 予約詳細の取得
const getReservationDetail = async () => {
    // 初期化
    userStatus.value = [];
    try {
        const res = await adminApiFetch(
            `http://localhost/api/admins/reservation/time-slots/${timeSlotId}`,
            {
                method: "GET",
            },
        );
        // 予約日時を取得
        date.value = res.data.date;
        time.value = res.data.start_time.substring(0, 5);
        // 予約者がいる場合、利用状況を取得
        if (res.data.reservations) {
            for (let i = 0; i < res.data.reservations.length; i++) {
                userStatus.value.push({
                    name: res.data.reservations[i].name,
                    reservation_id: res.data.reservations[i].reservation_id,
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

// 利用済みに変更
const usedStatus = async (id) => {
    try {
        await adminApiFetch(`http://localhost/api/admins/reservation/${id}`, {
            method: "PUT",
            body: {
                status: "used",
            },
        });
        // 画面に変更を即反映する
        await getReservationDetail();
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 利用前に戻す
const reservedStatus = async (id) => {
    try {
        await adminApiFetch(`http://localhost/api/admins/reservation/${id}`, {
            method: "PUT",
            body: {
                status: "reserved",
            },
        });
        // 画面に変更を即反映する
        await getReservationDetail();
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 予約管理画面へ遷移
const reservations = () => {
    // 予約管理画面へ遷移
    return navigateTo({
        path: "/admin/reservations",
        query: { date: currentDate },
    });
};

// 初回実行
getReservationDetail();
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

.group {
    display: flex;
    flex-direction: row;
    align-items: center;
    width: 100%;
}

.status {
    width: 45%;
    font-size: 20px;
}

.update-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    cursor: pointer;
    padding: 10px 0;
    width: 45%;
    margin: 5px 0;
    font-size: 20px;
}

.cancel-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    cursor: pointer;
    padding: 10px 0;
    width: 45%;
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
