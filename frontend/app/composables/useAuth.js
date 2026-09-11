export const useAuth = () => {
    const cookieToken = useCookie("token");
    const token = useState("token", () => cookieToken.value || null);
    const user = useState("user", () => null);

    watch(token, (newVal) => {
        cookieToken.value = newVal;
    });

    // tokenがある場合、ユーザー名を取得する
    const fetchUser = async () => {
        if (!token.value) return;
        const res = await apiFetch("http://localhost/api/auth/me");
        user.value = res;
    };

    // ログアウト
    const logout = async () => {
        // サーバー側ログアウト
        await $fetch("http://localhost/api/auth/logout", {
            method: "POST",
            headers: {
                // JWT等を使用している場合はここでAuthorizationヘッダーを渡す
                Authorization: `Bearer ${token.value}`,
            },
        });

        // クライアント側ログアウト
        token.value = null;
        // ユーザーの情報を削除
        user.value = null;
        // ログイン画面へ遷移する
        navigateTo("/login");
    };

    return {
        user,
        token,
        fetchUser,
        logout,
    };
};
