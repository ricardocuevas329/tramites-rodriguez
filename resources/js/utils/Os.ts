
export const getOSInfo = () => {
    const configScreen =  1024
    return {
      isMobile: window.innerWidth < configScreen ? true : false
    }
  }