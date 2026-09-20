<template>
    <div class="reservation">
        <p v-if="errorMessage" class="header-error-message">
            {{ errorMessage }}
        </p>
        <p v-else-if="message" class="header-success-message">{{ message }}</p>
        <div class="reservation-content">
            <h2 class="title">{{ year }}年{{ month }}月</h2>
            <div class="table-scroll-wrapper">
                <table class="reservation-list">
                    <tbody>
                        <tr>
                            <th class="fix-th">受付時刻</th>
                            <template v-for="i in 7">
                                <th class="fix-th">
                                    {{ dates[i - 1].slice(8) }}({{
                                        days[i - 1]
                                    }})
                                </th>
                            </template>
                        </tr>
                        <template v-for="i in 10">
                            <tr>
                                <!-- 9時は頭を0で埋める(09:00) -->
                                <th>
                                    {{ (i + 8).toString().padStart(2, "0") }}:00
                                </th>
                                <template v-for="j in 7">
                                    <!-- 9時は頭を0で埋める(09:00) -->
                                    <td
                                        :class="
                                            statusMap[
                                                `${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:00`
                                            ].class
                                        "
                                    >
                                        <!-- 「×」表示のボタンを無効化 -->
                                        <button
                                            class="table-cell-btn"
                                            type="button"
                                            :disabled="
                                                statusMap[
                                                    `${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:00`
                                                ].text === '×'
                                            "
                                            @click="
                                                confirm(
                                                    `${dates[j - 1]}`,
                                                    `${(i + 8).toString().padStart(2, '0')}:00`,
                                                    statusMap[
                                                        `${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:00`
                                                    ].text,
                                                )
                                            "
                                        >
                                            {{
                                                statusMap[
                                                    `${dates[j - 1]}_${(i + 8).toString().padStart(2, "0")}:00`
                                                ].text
                                            }}
                                        </button>
                                    </td>
                                </template>
                            </tr>
                            <tr>
                                <!-- 9時は頭を0で埋める(09:00) -->
                                <th>
                                    {{ (i + 8).toString().padStart(2, "0") }}:30
                                </th>
                                <template v-for="j in 7">
                                    <!-- 9時は頭を0で埋める(09:00) -->
                                    <td
                                        :class="
                                            statusMap[
                                                `${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:30`
                                            ].class
                                        "
                                    >
                                        <!-- 「×」表示のボタンを無効化 -->
                                        <button
                                            class="table-cell-btn"
                                            type="button"
                                            :disabled="
                                                statusMap[
                                                    `${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:00`
                                                ].text === '×'
                                            "
                                            @click="
                                                confirm(
                                                    `${dates[j - 1]}`,
                                                    `${(i + 8).toString().padStart(2, '0')}:30`,
                                                    statusMap[
                                                        `${dates[j - 1]}_${(i + 8).toString().padStart(2, '0')}:30`
                                                    ].text,
                                                )
                                            "
                                        >
                                            {{
                                                statusMap[
                                                    `${dates[j - 1]}_${(i + 8).toString().padStart(2, "0")}:30`
                                                ].text
                                            }}
                                        </button>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <p class="legend">
                ○：空きあり。 △：残りわずか。 ×：予約不可。 ✓：予約済み。
            </p>
        </div>
    </div>
</template>

<script setup>
// インポート
import { ref, computed } from "vue";

// 今日の日付を取得
const today = new Date();
// 今年
const year = today.getFullYear();
// 今月(1~9月は頭を0で埋める(例：01月))
const month = (today.getMonth() + 1).toString().padStart(2, "0");
// 現在の時間
const hour = today.getHours().toString().padStart(2, "0");
// 現在の分
const minute = today.getMinutes().toString().padStart(2, "0");
// 現在の時刻
const currentTime = `${hour}:${minute}`;
// 年月日
const dates = ref([]);
// 曜日
const days = ref([]);
// 曜日のテキスト
const weekday = ["日", "月", "火", "水", "木", "金", "土"];
// 予約一覧
// 例: [{ user_id: "1", date: "2026-07-15", time: "09:00" }]
const reservations = ref([]);
// 日時枠
// 例: [{ "date": "2026-09-15", "start_time": "10:30", "capacity": 7 }]
const timeSlots = ref([]);
// {user:データ（状態）, token: トークン, fetchUser: データを取得する関数 }
const { user, token, fetchUser } = useAuth();
const isLoggedIn = computed(() => {
    return !!token.value;
});
// URLのクエリパラメータからメッセージのキーを取得
const route = useRoute();
const messageKey = route.query.message;
// キーに対応する表示用メッセージのマッピング
const messageMap = {
    success: "予約が完了しました",
    delete: "予約を取り消しました",
};
const errorMessageMap = {
    past_datetime: "過去の日時は選択できません",
    invalid_slot: "ご指定の日時は予約枠が存在しないか、受付を終了しています",
    slot_full: "大変申し訳ありません。ご指定の予約枠は満員となりました",
    already_booked:
        "すでに同じ日時でご予約を承っているため、重複して予約することはできません",
};
const message = ref(messageMap[messageKey] || "");
// 画面リロード時にメッセージが再表示されるのを防ぐため、URLを書き換える目的で使用
const router = useRouter();
// エラーメッセージ
const errorMessage = ref(errorMessageMap[messageKey] || "");
// 予約成功メッセージのタイマー
let messageTimerId = null;
// エラーメッセージのタイマー
let errorTimerId = null;
// 予約ユーザーとログインユーザーの比較用
let isLoginUserReserved = false;

// 画面構成後に処理
onMounted(async () => {
    // 3秒後に予約メッセージが非表示になる
    if (message.value) {
        messageTimerId = setTimeout(() => {
            message.value = "";
            router.replace({ query: { ...route.query, message: undefined } });
        }, 3000);
    }
    // 6秒後にエラーメッセージが非表示になる
    if (errorMessage.value) {
        errorTimerId = setTimeout(() => {
            errorMessage.value = "";
            router.replace({ query: { ...route.query, message: undefined } });
        }, 6000);
    }
    // tokenがある場合、ユーザー名を取得する
    if (isLoggedIn.value) {
        await fetchUser();
    }
});

// 画面を離れる時は、動いているタイマーを「すべて」完全に抹消する
onUnmounted(() => {
    if (messageTimerId) clearTimeout(messageTimerId);
    if (errorTimerId) clearTimeout(errorTimerId);
});

// 7日分用意する
for (let i = 0; i < 7; i++) {
    const d = new Date(today);
    // 月末日に+1した場合、自動的に翌月の1日に進む
    d.setDate(today.getDate() + i);
    // 年月日を取得(月日は頭を0で埋める(例：01日))
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, "0");
    const day = String(d.getDate()).padStart(2, "0");
    // 年月日を取得
    dates.value.push(`${y}-${m}-${day}`);
    // 曜日を取得
    days.value.push(weekday[d.getDay()]);
}

// 予約データの作成
const makeReservations = async () => {
    try {
        const res = await $fetch("http://localhost/api/reservation", {
            method: "GET",
        });
        // APIの配列を1つずつ整形
        for (let i = 0; i < res.data.length; i++) {
            reservations.value.push({
                user_id: res.data[i].user_id,
                date: res.data[i].date,
                time: res.data[i].start_time.substring(0, 5),
            });
        }
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 日時枠の取得
const makeTimeSlots = async () => {
    try {
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
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 予約数を集計する
const reservationMap = computed(() => {
    const map = {};

    reservations.value.forEach((r) => {
        const key = `${r.date}_${r.time}`;
        // map[key]が存在しない場合、0に1をプラス
        map[key] = (map[key] || 0) + 1;
    });
    return map;
});

// ユーザー予約判定
const userMap = computed(() => {
    const map = {};

    reservations.value.forEach((r) => {
        const key = `${r.date}_${r.time}`;
        // map[key]がまだ無ければ、先に空の配列[]を作る
        if (!map[key]) {
            map[key] = [];
        }
        // map[key]にuser_idを追加
        map[key].push(r.user_id);
    });
    return map;
});

// 表示用データをすべて作成する
const statusMap = computed(() => {
    const result = {};

    // 各日付
    for (let d of dates.value) {
        // 各時間
        for (let h = 9; h <= 18; h++) {
            // 00分or30分
            for (let m of ["00", "30"]) {
                // 時間
                const time = `${h.toString().padStart(2, "0")}:${m}`;
                // 日付
                const date = d;
                // キー
                const key = `${date}_${time}`;
                // 予約取得数(reservationMap.value[key]が存在しない場合、0を取得)
                const count = reservationMap.value[key] || 0;
                // 予約ユーザーを全て取得
                const userReservation = userMap.value[key] || [];
                // 予約ユーザーの中に、ログインユーザーが含まれている場合trueを取得(ログイン中のみ処理)
                if (user.value) {
                    isLoginUserReserved = userReservation.includes(
                        user.value.id,
                    );
                }
                // 予約の日時が一致するtimeSlotsを取得
                const matchedSlot = timeSlots.value.find(
                    (t) => t.start_time === time && t.date === date,
                );

                // 予約人数の上限
                let capacity;
                // matchedSlotが取得できた時のみ、予約人数の上限を取得
                if (matchedSlot) {
                    capacity = matchedSlot.capacity;
                }

                // 状態決定
                // 過去の日時の場合、予約0でも予約不可能とする
                if (dates.value[0] == d && currentTime >= time) {
                    result[key] = { text: "×", class: "bg-gray" };
                    // capacityがうまく取得できなかった場合
                } else if (capacity === undefined) {
                    result[key] = { text: "⚪︎" };
                    // ログインユーザーが予約済みの場合
                } else if (isLoginUserReserved === true) {
                    result[key] = { text: "✔︎", class: "bg-blue" };
                    // 予約人数によって、表示を変更する
                } else if (count >= capacity) {
                    result[key] = { text: "×", class: "bg-gray" };
                    // 「△」と「○」は背景色を設定しない
                } else if (count >= capacity - 3) {
                    result[key] = { text: "△" };
                } else {
                    result[key] = { text: "⚪︎" };
                }
            }
        }
    }

    return result;
});

// 予約日時を持たせて確認画面へ遷移
const confirm = (confirmDate, confirmTime, text) => {
    // ボタンテキストが[✔︎]の場合、予約取り消し確認画面へ遷移
    if (text === "✔︎") {
        return navigateTo({
            path: `/confirm/${confirmDate}/${confirmTime}`,
            query: { mode: "cancel" },
        });
        // ボタンテキストが[⚪︎][△]の場合、確認画面へ遷移
    } else {
        return navigateTo({
            path: `/confirm/${confirmDate}/${confirmTime}`,
            query: { mode: "create" },
        });
    }
};

// 初回実行
makeTimeSlots();
makeReservations();
</script>

<style scoped>
p {
    margin: 0;
}

.reservation {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
    position: relative;
}

.header-success-message {
    background-color: #55c6a9;
    color: #304654;
    padding: 10px 20px;
    text-align: left;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    box-sizing: border-box;
}

.header-error-message {
    background-color: #e25c5c;
    color: #f5f5f5;
    padding: 10px 20px;
    text-align: left;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    box-sizing: border-box;
}

.reservation-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.table-scroll-wrapper {
    overflow: auto;
    width: 100%;
    height: 650px;
    margin-top: 80px;
}

.reservation-list {
    width: 90%;
    height: 80vh;
    margin: 0 auto;
    text-align: center;
    align-items: center;
    border-collapse: collapse;
    border: 1px solid #304654;
    color: #304654;
}

.fix-th {
    white-space: nowrap;
    background-color: #cce9fa;
    position: sticky;
    top: 0;
    left: 0;
    box-shadow:
        inset 0 1px 0 #304654,
        inset 0 -1px 0 #304654;
}

.table-cell-btn {
    width: 100%;
    height: 100%;
    padding: 0;
    background-color: transparent;
    color: #304654;
    font-family: "Hiragino Kaku Gothic ProN";
    font-size: 16px;
    border: none;
    cursor: pointer;
}

tr,
th,
td {
    border: 1px solid #304654;
}

.bg-gray {
    background-color: #d2d7df;
    pointer-events: none;
}

.bg-blue {
    background-color: #4ba3e3;
}

.legend {
    width: 90%;
    margin: 0 auto;
    text-align: left;
}
</style>
