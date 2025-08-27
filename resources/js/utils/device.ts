// src/composables/useDeviceInfo.ts

export interface DeviceInfo {
    deviceId: string;
    deviceType: 'Mobile' | 'Tablet' | 'Desktop' | 'Unknown';
    deviceName: string;
    userAgent: string;
  }

  export function useDeviceInfo(): DeviceInfo {
    const userAgent = navigator.userAgent;

    // 1. Determine device type from UA
    const deviceType = (() => {
      if (/mobile/i.test(userAgent)) return 'Mobile';
      if (/tablet|ipad/i.test(userAgent)) return 'Tablet';
      if (/Mac|Windows|Linux|X11/i.test(userAgent)) return 'Desktop';
      return 'Unknown';
    })();

    // 2. Generate or retrieve persistent device ID
    const storageKey = 'browser_device_id';
    let deviceId = localStorage.getItem(storageKey);
    if (!deviceId) {
      deviceId = crypto.randomUUID();
      localStorage.setItem(storageKey, deviceId);
    }

    // 3. Device name (optional: platform + browser)
    const deviceName = `${navigator.platform} - ${deviceType}`;

    return {
      deviceId,
      deviceType,
      deviceName,
      userAgent,
    };
  }
