export function endpoints() {
    return {
        login: "/auth/login",
        createUser: "/auth/register",
        updateUser: "/auth/user",
        refreshToken: "/auth/refresh",
        logout: "/auth/logout",
        getCategories: "/email-categories",
        fetchAttendanceByDate: "/attendance/by-date",
        takeAttendance: "/attendance",
        fetchAttendance: "/attendance/all",
        fetchUsers: "/users",
        fetchAllUsers: "/users/all",
        createSmsTemplate: "/sms-templates", //Post
        fetchSmsTemplates: "/sms-templates", //get
        updateSmsTemplate: "/sms-templates", //put
        deleteSmsTemplate: "/sms-templates", //delete
        createEmailTemplate: "/email-templates", //Post
        fetchEmailTemplates: "/email-templates", //get
        updateEmailTemplate: "/email-templates", //put
        deleteEmailTemplate: "/email-templates", //delete
        userStructre: "/users/structure",
        last4Sundays: "/attendance/last4sundays",
        userCount: "/users/count",
        totalPresent: "/attendance/total-present",
        totalAbsent: "/attendance/total-absent",
        recipients: "/recipients",
        addAdmin: "/users",
        fetchRoles:'/users/roles',
        fetchAdmins: '/users/admins',
        changePassword: '/users/change-password',
        sendCustomEmails: '/send-custom-messages'
    };
}
