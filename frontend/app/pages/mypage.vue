<template>
    <div class="mypage">
        <div class="mypage-content">
            <h2 class="title">マイページ</h2>
            <div class="mypage-card">
                <p class="section-title">【次回の予約】</p>
                <!-- 次回の予約がある場合 -->
                <div v-if="nextReservation" class="group">
                    <div class="item-group">
                        <p class="label">予約日</p>
                        <p class="item">
                            {{ formatDate(nextReservation.date) }}
                        </p>
                    </div>
                    <div class="item-group">
                        <p class="label">予約時間</p>
                        <p class="item">
                            {{ formatTime(nextReservation.time) }}
                        </p>
                    </div>
                    <button
                        class="delete-btn"
                        type="button"
                        @click="
                            confirm(nextReservation.date, nextReservation.time)
                        "
                    >
                        予約を取り消す
                    </button>
                </div>
                <!-- 次回の予約がない場合 -->
                <div v-else class="group">
                    <div class="item-group">
                        <p class="item">次回の予約はありません。</p>
                    </div>
                </div>
                <!-- 編集モード -->
                <form v-if="edit" @submit.prevent="update">
                    <div>
                        <p class="section-title">【会員情報】※編集モードです</p>
                    </div>
                    <div v-if="user" class="group">
                        <div class="item-group">
                            <p class="label">名前</p>
                            <input class="txt" type="text" v-model="name" />
                        </div>
                        <div class="item-group">
                            <p class="label">メールアドレス</p>
                            <input class="txt" type="text" v-model="email" />
                        </div>
                        <!-- パスワードは会員情報変更では変更不可 -->
                        <div class="item-group no-edit">
                            <p class="label">
                                ※パスワードはここでは変更できません
                            </p>
                            <p class="item">********</p>
                        </div>
                        <div class="item-group">
                            <p class="label">性別</p>
                            <select class="sel" v-model="gender">
                                <option value="男性">男性</option>
                                <option value="女性">女性</option>
                                <option value="その他">その他</option>
                                <option value="">未回答</option>
                            </select>
                        </div>
                        <div class="item-group">
                            <p class="label">住所</p>
                            <input class="txt" type="text" v-model="address" />
                        </div>
                        <div class="item-group">
                            <p class="label">電話番号</p>
                            <input class="txt" type="text" v-model="phone" />
                        </div>
                        <div class="btn-area">
                            <button class="update-btn" type="submit">
                                変更する
                            </button>
                            <button
                                class="cancel-btn"
                                type="button"
                                @click="informationCancel"
                            >
                                キャンセル
                            </button>
                        </div>
                    </div>
                </form>
                <!-- 閲覧モード -->
                <div v-else>
                    <div>
                        <p class="section-title">【会員情報】</p>
                    </div>
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
                            <p class="item">{{ user.gender || "未回答" }}</p>
                        </div>
                        <div class="item-group">
                            <p class="label">住所</p>
                            <p class="item">{{ user.address || "未回答" }}</p>
                        </div>
                        <div class="item-group">
                            <p class="label">電話番号</p>
                            <p class="item">{{ user.phone || "未回答" }}</p>
                        </div>
                        <div class="btn-area">
                            <!-- 未回答がある場合 -->
                            <button
                                v-if="isUser"
                                class="user-btn"
                                type="button"
                                @click="informationUpdate"
                            >
                                プロフィールの設定
                            </button>
                            <!-- 未回答がない場合 -->
                            <button
                                v-else
                                class="user-btn"
                                type="button"
                                @click="informationUpdate"
                            >
                                会員情報を変更する
                            </button>

                            <button class="password-btn" type="button">
                                パスワードを変更する
                            </button>
                        </div>
                    </div>
                </div>
                <p class="section-title">【予約履歴】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">予約中</p>
                        <!-- 予約データがある場合 -->
                        <table
                            v-if="reservedReservations.length !== 0"
                            class="reserved-list"
                        >
                            <tbody>
                                <template
                                    v-for="reservation in reservedReservations"
                                    :key="reservation.id"
                                >
                                    <tr>
                                        <td>
                                            {{ formatDate(reservation.date) }}
                                        </td>
                                        <td>
                                            {{ formatTime(reservation.time) }}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <!-- 予約データがない場合 -->
                        <div v-else>
                            <p class="item">予約履歴はありません。</p>
                        </div>
                    </div>
                    <div class="item-group">
                        <p class="label">利用済み</p>
                        <!-- 利用済み履歴がある場合 -->
                        <table
                            v-if="usedReservations.length !== 0"
                            class="used-list"
                        >
                            <tbody>
                                <template
                                    v-for="reservation in usedReservations"
                                    :key="reservation.id"
                                >
                                    <tr>
                                        <td>
                                            {{ formatDate(reservation.date) }}
                                        </td>
                                        <td>
                                            {{ formatTime(reservation.time) }}
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <!-- 利用済み履歴がない場合 -->
                        <div v-else>
                            <p class="item">利用済み履歴はありません。</p>
                        </div>
                    </div>
                </div>
                <p class="section-title">【利用実績】</p>
                <div class="group">
                    <div class="item-group">
                        <p class="label">累計利用回数</p>
                        <p class="item">{{ usedReservations.length }}回</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
// {user:データ（状態）, fetchUser: データを取得する関数 }
const { user, fetchUser } = useAuth();
// 予約一覧
// 例: [{ date: "2026-07-15", time: "09:00" }]
const reservations = ref([]);
// 今日の日付を取得
const today = new Date();
// 今年
const year = today.getFullYear();
// 今月(1~9月は頭を0で埋める(例：01月))
const month = (today.getMonth() + 1).toString().padStart(2, "0");
// 今月(1~9月は頭を0で埋める(例：01月))
const date = today.getDate().toString().padStart(2, "0");
// 現在の時間
const hour = today.getHours();
// 現在の分
const minute = today.getMinutes().toString().padStart(2, "0");
// 現在の年月日
const currentDate = `${year}-${month}-${date}`;
// 現在の時刻
const currentTime = `${hour}:${minute}`;
// 現在の日時
const currentDateTime = currentDate + " " + currentTime;
// 編集モード
const edit = ref(false);
// 現在の会員情報
const name = ref("");
const email = ref("");
const gender = ref("");
const address = ref("");
const phone = ref("");

// 認証中のみアクセス可能にする
definePageMeta({
    middleware: "auth",
});

// ログインユーザー取得
const getUser = async () => {
    await fetchUser();
};

// 予約データの作成
const makeReservations = async () => {
    const res = await $fetch("http://localhost/api/reservation", {
        method: "GET",
    });

    // APIの配列を1つずつ整形
    for (let i = 0; i < res.data.start_time.length; i++) {
        if (res.data.user_id[i] === user.value.id) {
            // ログインユーザーの予約データのみ取得
            reservations.value.push({
                date: res.data.date[i],
                time: res.data.start_time[i].substring(0, 5),
            });
        }
    }
};

// 日付→時間の優先順位で昇順に並び替え
const sortReservations = computed(() => {
    return [...reservations.value].sort((a, b) => {
        // 日付を比較
        const dateDiff = new Date(a.date) - new Date(b.date);

        // 日付が異なる（0以外）なら、その結果を返す
        if (dateDiff !== 0) return dateDiff;

        // 日付が同じ（0）なら、時間を文字列として比較
        return a.time.localeCompare(b.time);
    });
});

// 予約履歴(予約中)を取得
const reservedReservations = computed(() => {
    return sortReservations.value.filter((item) => {
        // 予約データの年月日と時間を結合(例：2026-08-14 09:00)
        const reservationDateTime = item.date + " " + item.time;
        // 次回の予約データを取得
        const next =
            nextReservation.value.date + " " + nextReservation.value.time;
        // 次回の予約データはreservedReservationsに含めない
        if (reservationDateTime !== next) {
            // 予約日時 > 現在の日時となるデータのみ取得
            return reservationDateTime > currentDateTime;
        }
    });
});

// 予約履歴(利用済み)を取得
const usedReservations = computed(() => {
    return sortReservations.value.filter((item) => {
        // 予約データの年月日と時間を結合(例：2026-08-14 09:00)
        const reservationDateTime = item.date + " " + item.time;
        // 予約日時 < 現在の日時となるデータのみ取得
        return reservationDateTime < currentDateTime;
    });
});

// 次回の予約を取得
const nextReservation = computed(() => {
    return sortReservations.value.find((item) => {
        // 予約データの年月日と時間を結合(例：2026-08-14 09:00)
        const reservationDateTime = item.date + " " + item.time;
        // 予約日時 > 現在の日時となる最初のデータのみ取得
        return reservationDateTime > currentDateTime;
    });
});

// 会員情報の未回答チェック
const isUser = computed(() => {
    if (
        user.value.gender === null ||
        user.value.address === null ||
        user.value.phone === null
    ) {
        // いずれかnullの場合trueを返す(未回答あり：プロフィールの設定)
        return true;
    } else {
        // 全て入力済みの場合falseを返す(未回答なし：会員情報を変更する)
        return false;
    }
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

// 次回の予約日時を持たせて、予約取り消し確認画面へ遷移
const confirm = (confirmDate, confirmTime) => {
    navigateTo({
        path: `/confirm/${confirmDate}/${confirmTime}`,
        query: { mode: "cancel" },
    });
};

// 編集モード
const informationUpdate = () => {
    // テキストボックスに現在の会員情報を入力
    name.value = user.value.name;
    email.value = user.value.email;
    gender.value = user.value.gender;
    address.value = user.value.address;
    phone.value = user.value.phone;
    // 編集モードに変更
    edit.value = true;
};

// 会員情報変更
const update = async () => {
    try {
        await apiFetch("http://localhost/api/user", {
            method: "PUT",
            body: {
                user_id: user.value.id,
                name: name.value,
                email: email.value,
                gender: gender.value,
                address: address.value,
                phone: phone.value,
            },
        });
        // 画面に変更を即反映する
        getUser();
        // 閲覧モードに変更
        edit.value = false;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// キャンセル
const informationCancel = () => {
    // 閲覧モードに変更
    edit.value = false;
};

// 初回実行
const init = async () => {
    await getUser();
    await makeReservations();
};

init();
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

.txt {
    background-color: #f5fbff;
    font-size: 18px;
    padding: 5px;
}

.sel {
    background-color: #f5fbff;
    font-size: 18px;
    padding: 5px;
}

.txt:focus-visible {
    background-color: #fde2e4;
}

.item {
    font-size: 18px;
    color: #304654;
    text-align: left;
}

.no-edit {
    background-color: #e5e5e5;
    color: #777;
}

.btn-area {
    display: flex;
    justify-content: center;
}

.delete-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.update-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.cancel-btn {
    border: none;
    background-color: #a7a7a7;
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
