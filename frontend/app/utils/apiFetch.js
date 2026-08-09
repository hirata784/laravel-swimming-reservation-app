export const apiFetch = async (url, options = {}) => {
    // トークンを取得
    const { token } = useAuth();
    // リフレッシュトークンを取得
    const refreshToken = useCookie("refresh_token");

    try {
        return await $fetch(url, {
            // 呼び出し元から渡された設定（method, bodyなど）を展開
            ...options,
            headers: {
                Authorization: `Bearer ${token.value}`,
                // 呼び出し元でheadersが指定されていればそれもマージ
                // （未定義対策で || {} をつけている）
                ...(options.headers || {}),
            },
        });
    } catch (error) {
        if (error.status === 401) {
            // トークンの有効期限が切れた場合はリフレッシュして新しいアクセストークンを取得
            const res = await $fetch("http://localhost/api/auth/refresh", {
                method: "POST",
                body: {
                    refresh_token: refreshToken.value,
                },
            });
            //  新しいアクセストークンを保存;
            token.value = res.access_token;

            // 再試行
            return await $fetch(url, {
                ...options,
                headers: {
                    Authorization: `Bearer ${token.value}`,
                    ...(options.headers || {}),
                },
            });
        }
        // 401以外のエラーはそのまま呼び出し元へ投げる
        throw error;
    }
};
