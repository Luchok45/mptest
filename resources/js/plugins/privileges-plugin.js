import { usePage } from '@inertiajs/vue3';

const elShowF = (el, show) => {
    if (!show) {
        el.style.display = 'none';
    }
};

/**
 * Текущий авторизованный пользователь = userId?
 * @param {number|null} userId
 * @returns {boolean}
 */
export const isCurrentAuthUser = (userId = null) => {
    return Number(usePage().props.auth.user?.data?.id) === userId;
};

/**
 * Базовая реализация функции can
 * @param {Object[]} permissions
 * @param {string} permission
 * @return {boolean}
 */
const baseCanF = (permissions, permission) => {
    for (let i = 0; i < permissions.length; i++) {
        if (permissions[i].name === permission) {
            return true;
        }
    }
    return false;
};

/**
 * Имеет ли переданный пользователь привилегию
 * @param {Object} user
 * @param {string} permission
 *
 * @return {boolean}
 */
export const userCanF = (user, permission) => {
    const permissions = user?.permissions ?? [];
    return baseCanF(permissions, permission);
};

/**
 * Имеет ли авторизованны пользователь привилегию
 * @param {string} permission
 * @returns {boolean}
 */
export const canF = (permission = '') => {
    const permissions = usePage().props.auth.permissions.data;
    return baseCanF(permissions, permission);
};

/**
 * Базовая реализация функции canAll
 * @param {Object[]} permissions
 * @param {string[]} checkPermissions
 * @return {boolean}
 */
const baseCanAllF = (permissions, checkPermissions) => {
    let can = true;
    if (Array.isArray(checkPermissions)) {
        for (let i = 0; i < checkPermissions.length; i++) {
            if (!baseCanF(permissions, checkPermissions[i])) {
                can = false;
            }
        }
    }
    return can;
};

/**
 * Имеет ли переданный пользователь все привилегии из списка
 * @param {Object} user
 * @param {string[]} checkPermissions
 * @return {boolean}
 */
export const userCanAllF = (user, checkPermissions) => {
    const permissions = user?.permissions ?? [];
    return baseCanAllF(permissions, checkPermissions);
};

/**
 * Имеет ли авторизованный пользователь все привилегии из списка
 * @param {string[]} checkPermissions
 * @return {boolean}
 */
export const canAllF = (checkPermissions = []) => {
    const permissions = usePage().props.auth.permissions.data;
    return baseCanAllF(permissions, checkPermissions);
};

/**
 * Базовая реализация функции canAny
 * @param {Object[]} permissions
 * @param {string[]} checkPermissions
 * @return {boolean}
 */
const baseCanAnyF = (permissions, checkPermissions) => {
    if (Array.isArray(checkPermissions)) {
        for (let i = 0; i < checkPermissions.length; i++) {
            if (baseCanF(permissions, checkPermissions[i])) {
                return true;
            }
        }
    }
    return false;
};

/**
 * Имеет ли переданный пользователь хотя-бы одну привилегию из списка
 * @param {Object} user
 * @param {string[]} checkPermissions
 * @return {boolean}
 */
export const userCanAnyF = (user, checkPermissions) => {
    const permissions = user?.permissions ?? [];
    return baseCanAnyF(permissions, checkPermissions);
};

/**
 * Имеет ли авторизованный пользователь хотя-бы одну привилегию из списка
 * @param {string[]} checkPermissions
 * @return {boolean}
 */
export const canAnyF = (checkPermissions = []) => {
    const permissions = usePage().props.auth.permissions.data;
    return baseCanAnyF(permissions, checkPermissions);
};

/**
 * Базовая реализация функции hasRole
 * @param {Object[]} roles
 * @param {string} role
 * @return {boolean}
 */
const baseHasRoleF = (roles, role) => {
    for (let i = 0; i < roles.length; i++) {
        if (roles[i].name === role) {
            return true;
        }
    }
    return false;
};

/**
 * Имеет ли переданный пользователь роль
 * @param {Object} user
 * @param {string} role
 * @return {boolean}
 */
export const userHasRoleF = (user, role) => {
    const roles = user?.roles ?? [];
    return baseHasRoleF(roles, role);
};

/**
 * Имеет ли авторизованный пользователь роль
 * @param {string} role
 * @return {boolean}
 */
export const hasRoleF = (role) => {
    const roles = usePage().props.auth.roles.data;
    return baseHasRoleF(roles, role);
};

/**
 * Базовая реализация функции hasAllRoles
 * @param {Object[]} roles
 * @param {string[]} checkRoles
 * @return {boolean}
 */
const baseHasAllRolesF = (roles, checkRoles) => {
    let has = true;
    if (Array.isArray(checkRoles)) {
        for (let i = 0; i < checkRoles.length; i++) {
            if (!baseHasRoleF(roles, checkRoles[i])) {
                has = false;
            }
        }
    }
    return has;
};

/**
 * Имеет ли переданный пользователь все роли из списка
 * @param {Object} user
 * @param {string[]} checkRoles
 * @return {boolean}
 */
export const userHasAllRolesF = (user, checkRoles) => {
    const roles = user?.roles ?? [];
    return baseHasAllRolesF(roles, checkRoles);
};

/**
 * Имеет ли авторизованный пользователь все роли из списка
 * @param {string[]} checkRoles
 * @return {boolean}
 */
export const hasAllRolesF = (checkRoles = []) => {
    const roles = usePage().props.auth.roles.data;
    return baseHasAllRolesF(roles, checkRoles);
};

/**
 * Базовая реализация функции hasAnyRoles
 * @param {Object[]} roles
 * @param {string[]} checkRoles
 * @return {boolean}
 */
const baseHasAnyRoleF = (roles, checkRoles) => {
    if (Array.isArray(checkRoles)) {
        for (let i = 0; i < checkRoles.length; i++) {
            if (baseHasRoleF(roles, checkRoles[i])) {
                return true;
            }
        }
    }
    return false;
};

/**
 * Имеет ли переданный пользователь хотя-бы одну роль из списка
 * @param {Object} user
 * @param {string[]} checkRoles
 * @return {boolean}
 */
export const userHasAnyRolesF = (user, checkRoles) => {
    const roles = user?.roles ?? [];
    return baseHasAnyRolesF(roles, checkRoles);
};

/**
 * Имеет ли авторизованный пользователь хотя-бы одну роль из списка
 * @param {string[]} checkRoles
 * @return {boolean}
 */
export const hasAnyRolesF = (checkRoles = []) => {
    const roles = usePage().props.auth.roles.data;
    return baseHasAnyRoleF(roles, checkRoles);
};

export default {
    install: (app, options) => {
        app.config.globalProperties.$isCurrentAuthUser = isCurrentAuthUser;

        app.config.globalProperties.$can = canF;
        app.config.globalProperties.$userCan = userCanF;
        app.config.globalProperties.$canAll = canAllF;
        app.config.globalProperties.$userCanAll = userCanAllF;
        app.config.globalProperties.$canAny = canAnyF;
        app.config.globalProperties.$userCanAny = userCanAnyF;

        app.config.globalProperties.$hasRole = hasRoleF;
        app.config.globalProperties.$userHasRole = userHasRoleF;
        app.config.globalProperties.$hasAllRoles = hasAllRolesF;
        app.config.globalProperties.$userHasAllRoles = userHasAllRolesF;
        app.config.globalProperties.$hasAnyRoles = hasAnyRolesF;
        app.config.globalProperties.$userHasAnyRoles = userHasAnyRolesF;

        app.directive('is-current-auth-user', (el, binding) => {
            elShowF(el, isCurrentAuthUser(binding.value));
        });
        app.directive('can', (el, binding) => {
            elShowF(el, canF(binding.value));
        });
        app.directive('can-all', (el, binding) => {
            elShowF(el, canAllF(binding.value));
        });
        app.directive('can-any', (el, binding) => {
            elShowF(el, canAnyF(binding.value));
        });

        app.directive('has-role', (el, binding) => {
            elShowF(el, hasRoleF(binding.value));
        });
        app.directive('has-all-roles', (el, binding) => {
            elShowF(el, hasAllRolesF(binding.value));
        });
        app.directive('has-any-roles', (el, binding) => {
            elShowF(el, hasAnyRolesF(binding.value));
        });
    },
};
