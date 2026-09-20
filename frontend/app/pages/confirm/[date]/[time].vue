<template>
    <div class="confirm">
        <div class="confirm-content">
            <h2 class="title">予約内容の確認</h2>
            <p v-if="isCancel" class="note">
                注意：下記内容の予約情報を取り消します！！
            </p>
            <form
                v-if="user"
                :class="{
                    'confirm-form': true,
                    cancel: isCancel,
                    create: !isCancel,
                }"
                @submit.prevent="handleSubmit(date, time)"
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
                        <p class="item">{{ formatTime(time) }}</p>
                    </div>
                </div>
                <div class="btn-area">
                    <button class="reservation-btn" type="submit">
                        {{ buttonText }}
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
// インポート
import { computed } from "vue";

// useRoute呼び出し
const route = useRoute();
// 予約日時取得
const date = route.params.date;
const time = route.params.time;
// クエリからモードを取得 ( route.query )
const mode = computed(() => route.query.mode || "create");
// モードによって表示を切り替え
const isCancel = computed(() => mode.value === "cancel");
const buttonText = computed(() =>
    isCancel.value ? "予約を取り消す" : "予約する",
);
// 年月日表示用
const year = date.substring(0, 4);
const month = date.substring(5, 7);
const dates = date.substring(8, 10);
const displayDate = `${year}年${month}月${dates}日`;
// {user:データ（状態）, fetchUser: データを取得する関数 }
const { user, fetchUser } = useAuth();

// 認証中のみアクセス可能にする
definePageMeta({
    middleware: "auth",
});

// 画面構成後に処理
onMounted(async () => {
    try {
        await fetchUser();

        // 予約日時の不適切チェック
        // 1. 過去日時
        // 現在の日時を取得
        const today = new Date();
        // 今年
        const currentYear = today.getFullYear();
        // 今月(1~9月は頭を0で埋める(例：01月))
        const currentMonth = (today.getMonth() + 1).toString().padStart(2, "0");
        // 今日(1~9日は頭を0で埋める(例：01日))
        const currentDay = today.getDate().toString().padStart(2, "0");
        // 現在の時間
        const currentHour = today.getHours().toString().padStart(2, "0");
        // 現在の分
        const currentMinute = today.getMinutes().toString().padStart(2, "0");

        // 比較用の本日日付
        const targetDate = `${currentYear}-${currentMonth}-${currentDay}`;
        // 比較用の時刻
        const targetTime = `${currentHour}:${currentMinute}`;

        // 過去日時の場合、予約一覧画面へ戻る
        // 今日 > 予約日(過去)
        if (targetDate > date) {
            navigateTo("/list");
            // 今日 === 予約日(時間を比較)
        } else if (targetDate === date) {
            // 現在の時間 >= 予約時間(過去)
            if (targetTime >= time) {
                navigateTo("/list");
            }
        }

        // 2. 予約枠データの有無
        // 日時枠
        const timeSlots = ref([]);

        const res = await $fetch("http://localhost/api/timeslot", {
            method: "GET",
        });
        // APIの配列を1つずつ整形
        for (let i = 0; i < res.data.length; i++) {
            timeSlots.value.push({
                date: res.data[i].date,
                start_time: res.data[i].start_time.substring(0, 5),
                capacity: res.data[i].capacity,
            });
        }

        // time_slotsテーブルにURLから取得した日時があるか確認
        const matchedSlot = timeSlots.value.find(
            (ts) => ts.start_time === time && ts.date === date,
        );

        // matchedSlotがない場合、予約一覧画面へ戻る
        if (!matchedSlot) {
            navigateTo("/list");
        }

        // 3. 予約人数が満員
        // 予約一覧
        const reservations = ref([]);

        // 予約中の人数を取得
        const reservationRes = await $fetch(
            "http://localhost/api/reservation",
            {
                method: "GET",
            },
        );
        // APIの配列を1つずつ整形
        for (let i = 0; i < reservationRes.data.length; i++) {
            reservations.value.push({
                user_id: reservationRes.data[i].user_id,
                date: reservationRes.data[i].date,
                time: reservationRes.data[i].start_time.substring(0, 5),
            });
        }

        // URLから取得した日時の予約中データを取得
        const targetReservations = reservations.value.filter(
            (r) => r.time === time && r.date === date,
        );
        // 予約中の人数をカウント
        const reservedCount = targetReservations.length;

        // 予約上限を取得
        const matchedCapacity = matchedSlot.capacity;

        // 予約中の人数が予約上限以上かつ予約モードの場合、予約一覧画面へ戻る
        if (reservedCount >= matchedCapacity && mode.value === "create") {
            navigateTo("/list");
        }

        // 4. ログアウト時の予約 ログインしたユーザーがすでに予約済み
        // ログインユーザーidを取得
        const myUserId = user.value.id;
        // 予約中のユーザーidにログインユーザーidが含まれているかチェック
        const myReservation = targetReservations.find(
            (tr) => tr.user_id === myUserId,
        );
        // 予約中のユーザーidにログインユーザーのidが含まれているかつ予約モードの場合、予約一覧へ戻る
        if (myReservation !== undefined && mode.value === "create") {
            navigateTo("/list");
        }
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
});

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

// 予約一覧画面へ遷移
const list = () => {
    navigateTo("/list");
};

// 予約の分岐点
const handleSubmit = (date, time) => {
    if (mode.value === "create") {
        // 予約確認画面の場合、予約処理
        addReservation(date, time);
    } else if (mode.value === "cancel") {
        // 予約取り消し確認画面の場合、予約取り消し処理
        deleteReservation(date, time);
    }
};

// 予約の処理を行う
const addReservation = async (date, time) => {
    try {
        await apiFetch("http://localhost/api/auth/reservation", {
            method: "POST",
            body: {
                date: date,
                start_time: time,
            },
        });
        // 予約一覧画面へ遷移
        navigateTo({
            path: "/list",
            query: { message: "success" },
        });
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 予約の取り消しを行う
const deleteReservation = async (date, time) => {
    try {
        await apiFetch("http://localhost/api/auth/reservation", {
            method: "DELETE",
            body: {
                date: date,
                start_time: time,
            },
        });
        // 予約一覧画面へ遷移
        navigateTo({
            path: "/list",
            query: { message: "delete" },
        });
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
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

.note {
    color: #da251d;
    font-size: 20px;
}

.confirm-form {
    width: 50%;
    max-width: 600px;
    padding: 30px 50px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.create {
    margin: 80px auto;
}

.cancel {
    margin: 50px auto 80px;
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
